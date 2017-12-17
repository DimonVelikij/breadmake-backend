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
        $name = $paramFetcher->get('Name');
        $phone = '+7' . $paramFetcher->get('Phone');
        $email = $paramFetcher->get('Email');

        /** @var EntityRepository $clientRepo */
        $clientRepo = $this->em->getRepository('BreadContentBundle:Client');

        $qb = $clientRepo->createQueryBuilder('client')
            ->where('client.phone = :client_phone')
            ->andWhere('client.email = :client_email')
            ->setParameters(['client_phone' => $phone, 'client_email' => $email]);

        $client = $qb->getQuery()->getOneOrNullResult();

        if (!$client) {
            $client = new Client();
            $client
                ->setName($name)
                ->setPhone($phone)
                ->setEmail($email);
        }

        return $client;
    }
}