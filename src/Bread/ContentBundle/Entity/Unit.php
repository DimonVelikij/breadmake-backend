<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Unit
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="units")
 * @ORM\Entity
 *
 * @JMS\ExclusionPolicy("all")
 */
class Unit
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\SerializedName("Id")
     * @JMS\Groups({"api"})
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
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ? $this->getTitle() : '';
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
     * @return Unit
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
}
