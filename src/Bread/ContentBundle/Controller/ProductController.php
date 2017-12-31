<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends BaseController
{
    /**
     * @Route("/products", name="product")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('@BreadContent/Product/product.html.twig', [
            'page'  =>  $this->getPage()
        ]);
    }
}