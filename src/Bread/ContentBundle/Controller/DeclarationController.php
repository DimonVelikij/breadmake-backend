<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DeclarationController extends BaseController
{
    /**
     * @Route("/declarations", name="declaration")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('@BreadContent/Declaration/declaration.html.twig', [
            'page'  =>  $this->getPage()
        ]);
    }
}