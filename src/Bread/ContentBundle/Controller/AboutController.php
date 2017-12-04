<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Entity\Company;
use Bread\ContentBundle\Repository\CompanyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AboutController extends Controller
{
    /**
     * @Route("/about", name="about")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        /** @var CompanyRepository $companyRepo */
        $companyRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Company');

        /** @var Company $company */
        $company = $companyRepo->findOneCompany();

        return $this->render('@BreadContent/About/about.html.twig', [
            'company'   =>  $company
        ]);
    }
}