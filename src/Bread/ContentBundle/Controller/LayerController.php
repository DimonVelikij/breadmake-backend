<?php

namespace Bread\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LayerController extends Controller
{
    /**
     * @Route("/layer/{name}", name="layer")
     * @param Request $request
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function layerAction(Request $request, $name)
    {
        return $this->render('@BreadContent/Layer/' . $name . '.html.twig');
    }
}