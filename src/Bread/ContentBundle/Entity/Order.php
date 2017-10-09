<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Order
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="orders")
 * @ORM\Entity
 */
class Order
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime $preferenceDate
     *
     * @ORM\Column(name="preference_date", type="datetime", nullable=false)
     */
    private $preferenceDate;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var boolean $isDelivery
     *
     * @ORM\Column(name="is_delivery", type="boolean", nullable=false, options={"default": false})
     */
    private $isDelivery;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="Bread\ContentBundle\Entity\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    private $status;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Bread\ContentBundle\Entity\Client", inversedBy="orders")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;

    /**
     * @var Order
     *
     * @ORM\OneToMany(targetEntity="Bread\ContentBundle\Entity\ProductOrder", mappedBy="order")
     */
    private $productsOrders;

    /**
     * @var string
     */
    private $preferenceDateFormat;

    /**
     * @var string
     */
    private $createdAtFormat;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getClient() ? "Заказ клиента '{$this->getClient()->getName()}'" : "Заказ";
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productsOrders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set preferenceDate
     *
     * @param \DateTime $preferenceDate
     *
     * @return Order
     */
    public function setPreferenceDate($preferenceDate)
    {
        $this->preferenceDate = $preferenceDate;

        return $this;
    }

    /**
     * Get preferenceDate
     *
     * @return \DateTime
     */
    public function getPreferenceDate()
    {
        return $this->preferenceDate;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Order
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isDelivery
     *
     * @param boolean $isDelivery
     *
     * @return Order
     */
    public function setIsDelivery($isDelivery)
    {
        $this->isDelivery = $isDelivery;

        return $this;
    }

    /**
     * Get isDelivery
     *
     * @return boolean
     */
    public function getIsDelivery()
    {
        return $this->isDelivery;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Order
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set status
     *
     * @param \Bread\ContentBundle\Entity\Status $status
     *
     * @return Order
     */
    public function setStatus(\Bread\ContentBundle\Entity\Status $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Bread\ContentBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set client
     *
     * @param \Bread\ContentBundle\Entity\Client $client
     *
     * @return Order
     */
    public function setClient(\Bread\ContentBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Bread\ContentBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Add productsOrder
     *
     * @param \Bread\ContentBundle\Entity\ProductOrder $productsOrder
     *
     * @return Order
     */
    public function addProductsOrder(\Bread\ContentBundle\Entity\ProductOrder $productsOrder)
    {
        $this->productsOrders[] = $productsOrder;

        return $this;
    }

    /**
     * Remove productsOrder
     *
     * @param \Bread\ContentBundle\Entity\ProductOrder $productsOrder
     */
    public function removeProductsOrder(\Bread\ContentBundle\Entity\ProductOrder $productsOrder)
    {
        $this->productsOrders->removeElement($productsOrder);
    }

    /**
     * Get productsOrders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductsOrders()
    {
        return $this->productsOrders;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getPreferenceDateFormat($format = 'Y-m-d H:i')
    {
        if (!$this->preferenceDate) {
            return '';
        }

        return $this->preferenceDate->format($format);
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getCreatedAtFormat($format = 'Y-m-d H:i')
    {
        if (!$this->createdAt) {
            return '';
        }

        return $this->createdAt->format($format);
    }
}
