<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Bread\ContentBundle\Entity\Company;
use Bread\ContentBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PriceListController extends BaseController
{
    /**
     * @Route("/price-list", name="price-list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('@BreadContent/PriceList/price_list.html.twig', [
            'page'  =>  $this->getPage()
        ]);
    }

    /**
     * @Route("/price-list/pdf", name="price-list-pdf")
     * @param Request $request
     * @return Response
     */
    public function pdfAction(Request $request)
    {
        $html = $this->renderView('@BreadContent/PriceList/price_list_pdf.html.twig', [
            'products'  =>  $this->getDownloadProducts($request)
        ]);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            [
                'Content-Type'          =>  'application/pdf',
                'Content-Disposition'   =>  'attachment; filename="price-list.pdf"'
            ]
        );
    }

    /**
     * @Route("/price-list/excel", name="price-list-excel")
     * @param Request $request
     * @return Response
     */
    public function excelAction(Request $request)
    {
        /** @var Company $company */
        $company = $this->getDoctrine()
            ->getRepository('BreadContentBundle:Company')
            ->findOneCompany();

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject
            ->getProperties()
            ->setCreator($company->getTitle())
            ->setLastModifiedBy($company->getTitle())
            ->setTitle('Прайс-лист');

        $phpExcelObject->createSheet(0);
        $phpExcelObject->setActiveSheetIndex(0);
        $phpExcelObject->getActiveSheet()->setTitle('Прайс-лист');

        $products = $this->getDownloadProducts($request);

        $cells = $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Товар')
            ->setCellValue('B1', 'Категория')
            ->setCellValue('C1', 'Цена, руб');

        /**
         * @var integer $index
         * @var Product $product
         */
        foreach ($products as $index => $product) {
            $cells
                ->setCellValue('A' . ($index + 2), $product->getTitle())
                ->setCellValue('B' . ($index + 2), $product->getCategory()->getTitle())
                ->setCellValue('C' . ($index + 2), $product->getPrice());
        }

        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');

        $response = $this->get('phpexcel')->createStreamedResponse($writer);

        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'price-list.xlsx'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getDownloadProducts(Request $request)
    {
        $productIds = $request->get('product_ids');

        /** @var EntityRepository $productRepo */
        $productRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Product');

        $products = $productIds ?
            $productRepo->findBy(['id' => explode(',', $productIds)]) :
            $products = $productRepo->findAll();

        return $products;
    }
}