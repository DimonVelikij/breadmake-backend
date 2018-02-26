<?php

namespace Bread\ApiBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Prefix("news")
 * @Rest\NamePrefix("api-news-")
 *
 * Class NewsController
 * @package Bread\ApiBundle\Controller
 */
class NewsController extends FOSRestController
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
        /** @var EntityRepository $newsRepo */
        $newsRepo = $this->getDoctrine()->getRepository('BreadContentBundle:News');

        /** @var QueryBuilder $qb */
        $qb = $newsRepo->createQueryBuilder('n');

        return $qb
            ->where('n.public = :is_public')
            ->setParameters(['is_public' => true])
            ->getQuery()
            ->getResult();
    }

    /**
     * @Rest\Route(path="/{id}", methods={"GET"}, requirements={"id": "\d+"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @param int $id
     *
     * @return array|null
     */
    public function resourceItemAction(int $id)
    {
        /** @var EntityRepository $newsRepo */
        $newsRepo = $this->getDoctrine()->getRepository('BreadContentBundle:News');

        /** @var QueryBuilder $qb */
        $qb = $newsRepo->createQueryBuilder('n');

        return $qb
            ->where('n.public = :is_public')
            ->andWhere('n.id = :id')
            ->setParameters(['is_public' => true, 'id' => $id])
            ->getQuery()
            ->getOneOrNullResult();
    }
}