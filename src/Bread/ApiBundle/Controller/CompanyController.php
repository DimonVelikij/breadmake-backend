<?php

namespace Bread\ApiBundle\Controller;

use Bread\ContentBundle\Repository\CompanyRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Prefix("company")
 * @Rest\NamePrefix("api-company-")
 *
 * Class CompanyController
 * @package Bread\ApiBundle\Controller
 */
class CompanyController extends FOSRestController
{
    /**
     * @Rest\Route(path="", methods={"GET"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     */
    public function resourceAction()
    {
        /** @var CompanyRepository $companyRepo */
        $companyRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Company');

        return [$companyRepo->findOneCompany()];//нужен массив, потому что в angular resource стоит опция isArray: true
    }
}