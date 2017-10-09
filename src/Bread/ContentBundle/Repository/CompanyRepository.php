<?php

namespace Bread\ContentBundle\Repository;

use Bread\ContentBundle\Entity\Company;
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