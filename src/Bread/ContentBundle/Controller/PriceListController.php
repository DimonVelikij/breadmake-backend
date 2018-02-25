<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $productIds = $request->get('product_ids');

        /** @var EntityRepository $productRepo */
        $productRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Product');

        $products = $productIds ?
            $productRepo->findBy(['id' => explode(',', $productIds)]) :
            $products = $productRepo->findAll();

        $html = $this->renderView('@BreadContent/PriceList/price_list_pdf.html.twig', [
            'products'  =>  $products
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
}