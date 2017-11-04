<?php

namespace Bread\ApiBundle\Controller;

use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Prefix("slide")
 * @Rest\NamePrefix("api-slide-")
 *
 * Class SliderController
 * @package Bread\ApiBundle\Controller
 */
class SlideController extends FOSRestController
{
    /**
     * @Rest\Route(path="", methods={"GET"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     */
    public function listAction()
    {
        /** @var EntityRepository $sliderRepo */
        $sliderRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Slide');
        $sliderQb = $sliderRepo->createQueryBuilder('s');
        return $sliderQb
            ->where('s.public = :public')
            ->andWhere($sliderQb->expr()->isNotNull('s.image'))
            ->setParameter('public', true)
            ->getQuery()
            ->getResult();
    }
}