<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Company;
use Doctrine\ORM\EntityRepository;

class CompanyRepository extends EntityRepository
{
    /**
     * @return Company
     */
    public function findOneCompany()
    {
        return $this->findAll()[0];
    }
}