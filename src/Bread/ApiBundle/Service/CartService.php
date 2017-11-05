<?php

namespace Bread\ApiBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class CartService
{
    /** @var Session  */
    private $session;

    /**
     * CartService constructor.
     *
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
     *
     * @return array|null
     */
    public function getCart()
    {
        $cart = $this->session->get('cart');

        return $cart ? $this->prepareCartData($cart) : [];
    }

    /**
     * получение элемента корзины
     *
     * @param int $id
     *
     * @return array
     */
    public function getCartItem(int $id)
    {
        $cart = $this->session->get('cart');

        if (!$cart || !isset($cart[$id])) {
            return [];
        }

        return $this->prepareCartData([
            $id => $cart[$id]
        ]);
    }

    /**
     * обновление корзины
     *
     * @param $id
     * @param $price
     * @param $count
     *
     * @return array|null
     */
    public function updateCart($id, $price, $count)
    {
        $cart = $this->session->get('cart');

        $cart[$id] = [
            'price' =>  $price,
            'count' =>  $count
        ];

        $this->session->set('cart', $cart);

        return $this->prepareCartData([
            $id => $cart[$id]
        ]);
    }

    /**
     * удаление элемента корзины
     *
     * @param int $id
     *
     * @return array
     */
    public function removeItemCart(int $id)
    {
        $cart = $this->session->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);

            if (empty($cart)) {
                $this->clearCart();

                return [];
            }
        }

        $this->session->set('cart', $cart);

        return $this->prepareCartData($cart);
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

    /**
     * подготовка данных корзины
     *
     * @param array $cartData
     *
     * @return array
     */
    public function prepareCartData(array $cartData)
    {
        $cartContent = [];

        foreach ($cartData as $productId => $productParams) {
            $cartContent[] = [
                'ProductId' =>  $productId,
                'Price'     =>  $productParams['price'],
                'Count'     =>  $productParams['count']
            ];
        }

        return $cartContent;
    }
}