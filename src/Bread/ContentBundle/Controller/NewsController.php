<?php

namespace Bread\ContentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    /**
     * @Route("/news", name="news")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('@BreadContent/News/list.html.twig');
    }

    /**
     * @Route("/news/{id}", name="new-item", requirements={"id"="\d+"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newItemAction(Request $request, $id)
    {
        return $this->render('@BreadContent/News/new_item.html.twig', [
            'id'    =>  $id
        ]);
    }
}