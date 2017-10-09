<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Entity\Company;
use Bread\ContentBundle\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{
    /**
     * генерация шаблона хедера
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function headerAction()
    {
        /** @var CompanyRepository $companyRepo */
        $companyRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Company');

        /** @var Company $company */
        $company = $companyRepo->findOneCompany();

        return $this->render('@BreadContent/Layout/header.html.twig', [
            'company'   =>  $company
        ]);
    }

    /**
     * генерация шаблона футера
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function footerAction()
    {
        $productCategories = $this->getDoctrine()->getRepository('BreadContentBundle:Category')->findAll();

        /** @var CompanyRepository $companyRepo */
        $companyRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Company');

        /** @var Company $company */
        $company = $companyRepo->findOneCompany();

        return $this->render('@BreadContent/Layout/footer.html.twig', [
            'product_categories'    =>  $productCategories,
            'company'               =>  $company
        ]);
    }
}