<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Client
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="clients")
 * @ORM\Entity
 */
class Client
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=false)
     */
    private $phone;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=50, unique=true, nullable=true)
     */
    private $email;

    /**
     * @var string $login
     *
     * @ORM\Column(name="login", type="string", length=50, unique=true, nullable=true)
     */
    private $login;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var bool $isRegistration
     *
     * @ORM\Column(name="is_registration", type="boolean", nullable=false, options={"default": false})
     */
    private $isRegistration;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bread\ContentBundle\Entity\Order", mappedBy="client")
     */
    private $orders;

    /**
     * @var int
     */
    private $countOrders;

    /**
     * @var string
     */
    private $createdAtFormat;

    /**
     * @var string
     */
    private $updatedAtFormat;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName() ? $this->getName() : '';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Client
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Client
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add order
     *
     * @param \Bread\ContentBundle\Entity\Order $order
     *
     * @return Client
     */
    public function addOrder(\Bread\ContentBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \Bread\ContentBundle\Entity\Order $order
     */
    public function removeOrder(\Bread\ContentBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set isRegistration
     *
     * @param boolean $isRegistration
     *
     * @return Client
     */
    public function setIsRegistration($isRegistration)
    {
        $this->isRegistration = $isRegistration;

        return $this;
    }

    /**
     * Get isRegistration
     *
     * @return boolean
     */
    public function getIsRegistration()
    {
        return $this->isRegistration;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Client
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Client
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getCountOrders()
    {
        return count($this->getOrders());
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

    /**
     * @param string $format
     *
     * @return string
     */
    public function getUpdatedAtFormat($format = 'Y-m-d H:i')
    {
        if (!$this->createdAt) {
            return '';
        }

        return $this->createdAt->format($format);
    }
}
