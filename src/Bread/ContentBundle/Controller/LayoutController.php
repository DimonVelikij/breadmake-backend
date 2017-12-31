<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Bread\ContentBundle\Entity\Company;
use Bread\ContentBundle\Repository\CompanyRepository;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

class LayoutController extends BaseController
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

    /**
     * генерация конфигов для inizializer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function initializerDataAction()
    {
        /** @var CsrfTokenManager $tokenManager */
        $tokenManager = $this->get('security.csrf.token_manager');
        $tokenManager->refreshToken('form');

        return $this->render('@BreadContent/Layout/initializer-data.html.twig', [
            'token'     =>  $tokenManager->getToken('form')->getValue()
        ]);
    }
}