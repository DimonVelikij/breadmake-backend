<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Company
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="company")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Bread\ContentBundle\Repository\CompanyRepository")
 *
 * @JMS\ExclusionPolicy("all")
 */
class Company
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("Title")
     * @JMS\Groups({"api"})
     */
    private $title;

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("Phone")
     * @JMS\Groups({"api"})
     */
    private $phone;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("Email")
     * @JMS\Groups({"api"})
     */
    private $email;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("Address")
     * @JMS\Groups({"api"})
     */
    private $address;

    /**
     * @var string $data
     *
     * @ORM\Column(name="data", type="object", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("array")
     * @JMS\SerializedName("Data")
     * @JMS\Groups({"api"})
     */
    private $data;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
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
     * Set title
     *
     * @param string $title
     *
     * @return Company
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Company
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
     * @return Company
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
     * Set address
     *
     * @param string $address
     *
     * @return Company
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
     * Set data
     *
     * @param string $data
     *
     * @return Company
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
}
