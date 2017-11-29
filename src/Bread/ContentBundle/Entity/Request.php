<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Request
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="requests")
 * @ORM\Entity
 */
class Request
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
     * @var string $data
     *
     * @ORM\Column(name="data", type="object", nullable=true)
     */
    private $data;

    /**
     * @var RequestType
     *
     * @ORM\ManyToOne(targetEntity="Bread\ContentBundle\Entity\RequestType")
     * @ORM\JoinColumn(name="request_type_id", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @var Client
     * 
     * @ORM\ManyToOne(targetEntity="Bread\ContentBundle\Entity\Client", inversedBy="requests", cascade={"persist"})
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;

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
     * Set data
     *
     * @param string $data
     *
     * @return Request
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

    /**
     * Set type
     *
     * @param \Bread\ContentBundle\Entity\RequestType $type
     *
     * @return Request
     */
    public function setType(\Bread\ContentBundle\Entity\RequestType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Bread\ContentBundle\Entity\RequestType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set client
     *
     * @param \Bread\ContentBundle\Entity\Client $client
     *
     * @return Request
     */
    public function setClient(\Bread\ContentBundle\Entity\Client $client = null)
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
}
