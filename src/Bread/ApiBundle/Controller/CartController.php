<?php

namespace Bread\ApiBundle\Controller;

use Bread\ApiBundle\Service\CartService;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;

/**
 * @Rest\Prefix("cart")
 * @Rest\NamePrefix("api-cart-")
 *
 * Class CartController
 * @package Bread\ApiBundle\Controller
 */
class CartController extends FOSRestController
{
    /**
     * @Rest\Route(path="", methods={"GET"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @return array|null
     */
    public function resourceAction()
    {
        try {
            return $this->getCartService()->getCart();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @Rest\Route(path="/{id}", methods={"GET"}, requirements={"id": "\d+"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @param int $id
     *
     * @return array|string
     */
    public function resourceItemAction(int $id)
    {
        try {
            return $this->getCartService()->getCartItem($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @Rest\Route(path="/update/{id}", methods={"GET"}, requirements={"id": "\d+"})
     *
     * @Rest\QueryParam(
     *     name="price",
     *     requirements="(\d+(\.\d{1,2})?)",
     *     nullable=false,
     *     allowBlank=false,
     *     strict=true
     * )
     *
     * @Rest\QueryParam(
     *     name="count",
     *     requirements="\d+",
     *     nullable=false,
     *     allowBlank=false,
     *     strict=true
     * )
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @param int $id
     * @param ParamFetcher $paramFetcher
     *
     * @return array|null|string
     */
    public function updateAction(int $id, ParamFetcher $paramFetcher)
    {
        try {
            $price = $paramFetcher->get('price');
            $count = $paramFetcher->get('count');

            return $this->getCartService()->updateCart($id, $price, $count);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @Rest\Route(path="/remove/{id}", methods={"GET"}, requirements={"id": "\d+"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @param int $id
     *
     * @return array|null
     */
    public function removeItemAction(int $id)
    {
        try {
            return $this->getCartService()->removeItemCart($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @Rest\Route(path="/remove", methods={"GET"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @return array|string
     */
    public function removeAction()
    {
        try {
            return $this->getCartService()->clearCart();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return CartService
     */
    private function getCartService()
    {
        return $this->get('bread_api.cart_service');
    }
}