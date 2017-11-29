<?php

namespace Bread\ApiBundle\Service;

use Bread\ContentBundle\Entity\Client;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Request\ParamFetcher;

class UserService
{
    /** @var EntityManager  */
    private $em;

    public function __construct(
        EntityManager $em
    ) {
        $this->em = $em;
    }

    /**
     * поиск или создание клиента
     * @param ParamFetcher $paramFetcher
     * @return Client
     */
    public function findOrCreateUser(ParamFetcher $paramFetcher)
    {
        $phone = '+7' . $paramFetcher->get('Phone');

        /** @var EntityRepository $clientRepo */
        $clientRepo = $this->em->getRepository('BreadContentBundle:Client');

        $qb = $clientRepo->createQueryBuilder('client')
            ->where('client.phone = :client_phone')
            ->setParameter('client_phone', $phone);

        $client = $qb->getQuery()->getOneOrNullResult();

        if (!$client) {
            $client = new Client();
            $client->setPhone($phone);
        }

        return $client;
    }
}