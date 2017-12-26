<?php

namespace Bread\ApiBundle\Controller;

use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Prefix("declaration")
 * @Rest\NamePrefix("api-declaration-")
 *
 * Class DeclarationController
 * @package Bread\ApiBundle\Controller
 */
class DeclarationController extends FOSRestController
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
        /** @var EntityRepository $declarationRepo */
        $declarationRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Declaration');
        $declarationQb = $declarationRepo->createQueryBuilder('d');

        return $declarationQb
            ->where($declarationQb->expr()->isNotNull('d.image'))
            ->getQuery()
            ->getResult();
    }
}