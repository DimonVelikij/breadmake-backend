<?php

namespace Bread\ApiBundle\Controller;

use Bread\ApiBundle\Service\RequestHelperService;
use Bread\ContentBundle\Entity\Client;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;

/**
 * @Rest\Prefix("request")
 * @Rest\NamePrefix("api-request-")
 *
 * Class RequestController
 * @package Bread\ApiBundle\Controller
 */
class RequestController extends FOSRestController
{
    /**
     * @Rest\Route(path="", methods={"POST"})
     *
     * @Rest\RequestParam(name="Name")
     *
     * @Rest\RequestParam(name="Phone")
     *
     * @Rest\RequestParam(
     *     name="Email",
     *     nullable=true
     * )
     *
     * @Rest\RequestParam(name="Type")
     *
     * @Rest\RequestParam(
     *     name="Agree",
     *     requirements="0|1",
     *     nullable=false,
     *     allowBlank=false,
     *     strict=true,
     *     default=false
     * )
     *
     * @Rest\RequestParam(
     *     name="Token",
     *     nullable=false,
     *     allowBlank=false,
     *     strict=true,
     *     default="token"
     * )
     *
     * @Rest\RequestParam(
     *     name="Data",
     *     nullable=true,
     *     allowBlank=false,
     *     strict=false
     * )
     *
     * @param ParamFetcher $paramFetcher
     *
     * @param ParamFetcher $paramFetcher
     * @return View
     * @throws \Exception
     */
    public function saveAction(ParamFetcher $paramFetcher)
    {
        if (!$this->isCsrfTokenValid('form', $paramFetcher->get('Token'))) {
            throw new \Exception('Invalid request token');
        }

        /** @var RequestHelperService $requestHelperService */
        $requestHelperService = $this->get('bread_api.request_helper_service');

        $requestErrors = $requestHelperService->validate($paramFetcher);

        /** @var View $view */
        $view = $this->view();

        if (count($requestErrors)) {
            return $view->setData([
                'success'   =>  false,
                'errors'    =>  $requestErrors
            ]);
        }

        //сохранение в базу и отправка письма

        return $view->setData([
            'success'   =>  true,
            'errors'    =>  false
        ]);
    }
}