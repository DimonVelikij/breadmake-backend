<?php

namespace Bread\ApiBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class CartService
{
    /** @var Session  */
    private $session;

    /**
     * CartService constructor.
     * @param Session $session
     */
    public function __construct(
        Session $session
    ) {
        $this->session = $session;
        $this->session->start();
    }

    /**
     * получение содержимого корзины
     * @param null $id
     * @return array|null
     */
    public function getCart($id = null)
    {
        $cart = $this->session->get('cart');

        if ($id && isset($cart[$id])) {
            return $cart[$id];
        }

        return $cart ?? [];
    }

    /**
     * обновление корзины
     * @param $id
     * @param $price
     * @param $count
     * @return array|null
     */
    public function updateCart($id, $price, $count)
    {
        $cart = $this->getCart();

        $cart[$id] = [
            'price' =>  $price,
            'count' =>  $count
        ];

        $this->session->set('cart', $cart);

        return [
            $id => $this->getCart($id)
        ];
    }

    /**
     * удаление элемента корзины
     * @param $id
     * @return array|null
     */
    public function removeItemCart($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            unset($cart[$id]);

            if (empty($cart)) {
                $this->clearCart();

                return [];
            }
        }

        $this->session->set('cart', $cart);

        return $cart;
    }

    /**
     * очистка корзины
     *
     * @return array
     */
    public function clearCart()
    {
        $this->session->set('cart', []);

        return [];
    }
}