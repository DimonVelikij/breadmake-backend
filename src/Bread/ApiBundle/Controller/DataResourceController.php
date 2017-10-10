<?php

namespace Bread\ApiBundle\Controller;

use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\NamePrefix("api-")
 * Class DataResourceController
 * @package Bread\ApiBundle\Controller
 */
class DataResourceController extends FOSRestController
{
    /**
     * @Rest\Get("/products")
     * @Rest\View(serializerGroups={"api"})
     */
    public function productsAction()
    {
        /** @var EntityRepository $productRepo */
        $productRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Product');
        return $productRepo->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
    }
}