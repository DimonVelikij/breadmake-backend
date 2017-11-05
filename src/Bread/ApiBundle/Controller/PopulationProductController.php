<?php

namespace Bread\ApiBundle\Controller;

use Bread\ContentBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Rest\Prefix("population-product")
 * @Rest\NamePrefix("api-population-product-")
 *
 * Class PopulationProductController
 * @package Bread\ApiBundle\Controller
 */
class PopulationProductController extends FOSRestController
{
    /**
     * @Rest\Route(path="", methods={"GET"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @return array
     */
    public function resourceAction()
    {
        $cart = $this->getSession()->get('cart');

        /** @var EntityRepository $productRepo */
        $productRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Product');

        /** @var QueryBuilder $qb */
        $qb = $productRepo->createQueryBuilder('p')
            ->where('p.public = :public')
            ->setParameters(['public' => true]);

        if ($cart) {
            $populationProducts = $qb->getQuery()->getResult();

            if (!count($populationProducts)) {
                return [];
            }

            /** @var Product $populationProduct */
            foreach ($populationProducts as $populationProduct) {
                if (isset($cart[$populationProduct->getId()])) {
                    $populationProduct->setIsInCart(true);
                }
            }

            return $populationProducts;
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Session
     */
    private function getSession()
    {
        return $this->get('session');
    }
}