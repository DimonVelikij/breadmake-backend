<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PriceListController extends BaseController
{
    /**
     * @Route("/price-list", name="price-list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('@BreadContent/PriceList/price_list.html.twig', [
            'page'  =>  $this->getPage()
        ]);
    }
}