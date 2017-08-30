<?php

namespace AppBundle\Admin;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Pool;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

trait AdminTrait
{
    /**
     * @return EntityManager
     */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @return null|\Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->getConfigurationPool()->getContainer();
    }

    /**
     * @param $object
     * @return array
     */
    protected function getOriginalObject($object)
    {
        return $this->getModelManager()
            ->getEntityManager($this->getClass())
            ->getUnitOfWork()
            ->getOriginalEntityData($object);
    }

    /**
     * @return Pool
     */
    abstract protected function getConfigurationPool();

    /**
     * @return ModelManager
     */
    abstract protected function getModelManager();

    /**
     * @return string
     */
    abstract protected function getClass();
}