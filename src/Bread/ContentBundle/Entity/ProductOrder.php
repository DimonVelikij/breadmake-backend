<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductOrder
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="products_orders")
 * @ORM\Entity
 */
class ProductOrder
{
    /**
     * @var Product
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Bread\ContentBundle\Entity\Product", inversedBy="productsOrders")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="cascade")
     */
    private $product;

    /**
     * @var Order
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Bread\ContentBundle\Entity\Order", inversedBy="productsOrders")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="cascade")
     */
    private $order;

    /**
     * @var integer $count
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return ProductOrder
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set product
     *
     * @param \Bread\ContentBundle\Entity\Product $product
     *
     * @return ProductOrder
     */
    public function setProduct(\Bread\ContentBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Bread\ContentBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set order
     *
     * @param \Bread\ContentBundle\Entity\Order $order
     *
     * @return ProductOrder
     */
    public function setOrder(\Bread\ContentBundle\Entity\Order $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Bread\ContentBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
