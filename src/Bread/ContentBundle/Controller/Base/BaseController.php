<?php

namespace Bread\ContentBundle\Controller\Base;

use Bread\ContentBundle\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    /**
     * @return Menu
     */
    protected function getPage()
    {
        /** @var Menu $menu */
        $menu = $this->getDoctrine()
            ->getRepository('BreadContentBundle:Menu')
            ->findOneBy(['path' => $this->getMasterRequest()->get('_route')]);

        return $menu;
    }

    /**
     * @return Request
     */
    private function getMasterRequest()
    {
        $request = $this->get('request_stack')->getMasterRequest();

        return $request;
    }
}