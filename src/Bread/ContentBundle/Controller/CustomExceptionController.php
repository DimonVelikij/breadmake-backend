<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class CustomExceptionController extends BaseController
{
    public function showExceptionAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        if ($this->getParameter('kernel.environment') == 'dev') {
            $exceptionController = new ExceptionController($this->get('twig'), true);

            return $exceptionController->showAction($request, $exception, $logger);
        }

        switch ($exception->getStatusCode()) {
            case 404:
                return $this->render('@BreadContent/Layout/Exception/404.html.twig');
            case 502:
                return $this->render('BreadContentBundle:Layout/Exception:502.html.twig');
            default:
                return $this->render('@BreadContent/Layout/Exception/500.html.twig');
        }
    }
}