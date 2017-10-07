<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Repository\CompanyRepository;
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
        $companyRepo = $this->getDoctrine()->getRepository('AppBundle:Company');

        /** @var Company $company */
        $company = $companyRepo->findOneCompany();

        return $this->render('AppBundle:Layout:header.html.twig', [
            'company'   =>  $company
        ]);
    }

    /**
     * генерация шаблона футера
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function footerAction()
    {
        $productCategories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        /** @var CompanyRepository $companyRepo */
        $companyRepo = $this->getDoctrine()->getRepository('AppBundle:Company');

        /** @var Company $company */
        $company = $companyRepo->findOneCompany();

        return $this->render('AppBundle:Layout:footer.html.twig', [
            'product_categories'    =>  $productCategories,
            'company'               =>  $company
        ]);
    }
}