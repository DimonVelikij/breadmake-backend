<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation as JMS;

/**
 * Class News
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="news")
 * @ORM\Entity
 *
 * @JMS\ExclusionPolicy("all")
 */
class News
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
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("Description")
     * @JMS\Groups({"api"})
     */
    private $description;

    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean", nullable=false, options={"default": true})
     */
    private $public;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("DateTime<'Y-m-d H:i'>")
     * @JMS\SerializedName("CreatedAt")
     * @JMS\Groups({"api"})
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="image_crop", type="string", length=255, nullable=true)
     */
    private $imageCrop;

    /**
     * @ORM\ManyToMany(targetEntity="Image")
     * @ORM\JoinTable(name="news_images",
     *     joinColumns={@ORM\JoinColumn(name="new_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id", unique=true
     * )})
     *
     * @JMS\Expose
     * @JMS\SerializedName("Images")
     * @JMS\Groups({"api"})
     */
    private $images;

    /**
     * @var UploadedFile[]
     */
    private $uploadedFiles;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?? '';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return News
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
     * Set description
     *
     * @param string $description
     *
     * @return News
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return News
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return News
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
     * Set imageCrop
     *
     * @param string $imageCrop
     *
     * @return News
     */
    public function setImageCrop($imageCrop)
    {
        $this->imageCrop = $imageCrop;

        return $this;
    }

    /**
     * Get imageCrop
     *
     * @return string
     */
    public function getImageCrop()
    {
        return $this->imageCrop;
    }

    /**
     * Add image
     *
     * @param \Bread\ContentBundle\Entity\Image $image
     *
     * @return News
     */
    public function addImage(\Bread\ContentBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Bread\ContentBundle\Entity\Image $image
     */
    public function removeImage(\Bread\ContentBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param $uploadedFiles
     * @return Product
     */
    public function setUploadedFiles($uploadedFiles)
    {
        $this->uploadedFiles = $uploadedFiles;

        return $this;
    }

    /**
     * @return UploadedFile[]
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }
}
