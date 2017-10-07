<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Menu;
use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    use ContainerAwareTrait;

    /** @var FactoryInterface  */
    private $factory;

    /**
     * Builder constructor.
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param EntityManager $em
     * @param RequestStack $request
     * @return \Knp\Menu\ItemInterface
     */
    public function makeMenu(EntityManager $em, RequestStack $request)
    {
        $menuItems = $em->getRepository('AppBundle:Menu')
            ->createQueryBuilder('menu')
            ->where('menu.public = :public')
            ->setParameter('public', true)
            ->orderBy('menu.sortableRank')
            ->getQuery()
            ->getResult();

        $menu = $this->factory->createItem('root');

        /** @var Menu $menuItem */
        foreach ($menuItems as $menuItem) {
            $currentMenuItem = $menu->addChild($menuItem->getTitle(), ['route' => $menuItem->getPath()]);
            if ($request->getMasterRequest()->attributes->get('_route') == $menuItem->getPath()) {
                $currentMenuItem->setCurrent(true);
            }
        }

        return $menu;
    }
}