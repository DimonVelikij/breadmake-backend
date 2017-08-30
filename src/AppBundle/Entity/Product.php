<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Product
 * @package AppBundle\Entity
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Product
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
     */
    private $title;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var float $weight
     *
     * @ORM\Column(name="weigth", type="decimal", precision=5, scale=3, nullable=false)
     */
    private $weight;

    /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var boolean $isNew
     *
     * @ORM\Column(name="is_new", type="boolean", nullable=false, options={"default": false})
     */
    private $isNew;

    /**
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean", nullable=false, options={"default": true})
     */
    private $public;

    /**
     * @var boolean $isPopulation
     *
     * @ORM\Column(name="is_population", type="boolean", nullable=false, options={"default": false})
     */
    private $isPopulation;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

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
     * @var Flour
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Flour")
     * @ORM\JoinColumn(name="flour_id", referencedColumnName="id", nullable=false)
     */
    private $flour;

    /**
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id", nullable=false)
     */
    private $unit;

    /**
     * @var Order
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProductOrder", mappedBy="product")
     */
    private $productsOrders;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="image_crop", type="string", length=255, nullable=true)
     */
    private $imageCrop;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

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
     * Set title
     *
     * @param string $title
     *
     * @return Product
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
     * @return Product
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
     * Set weight
     *
     * @param string $weight
     *
     * @return Product
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     *
     * @return Product
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return boolean
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return Product
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
     * Set isPopulation
     *
     * @param boolean $isPopulation
     *
     * @return Product
     */
    public function setIsPopulation($isPopulation)
    {
        $this->isPopulation = $isPopulation;

        return $this;
    }

    /**
     * Get isPopulation
     *
     * @return boolean
     */
    public function getIsPopulation()
    {
        return $this->isPopulation;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
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
     * @return Product
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
     * Set imageCrop
     *
     * @param string $imageCrop
     *
     * @return Product
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set flour
     *
     * @param \AppBundle\Entity\Flour $flour
     *
     * @return Product
     */
    public function setFlour(\AppBundle\Entity\Flour $flour)
    {
        $this->flour = $flour;

        return $this;
    }

    /**
     * Get flour
     *
     * @return \AppBundle\Entity\Flour
     */
    public function getFlour()
    {
        return $this->flour;
    }

    /**
     * Set unit
     *
     * @param \AppBundle\Entity\Unit $unit
     *
     * @return Product
     */
    public function setUnit(\AppBundle\Entity\Unit $unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \AppBundle\Entity\Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Add productsOrder
     *
     * @param \AppBundle\Entity\ProductOrder $productsOrder
     *
     * @return Product
     */
    public function addProductsOrder(\AppBundle\Entity\ProductOrder $productsOrder)
    {
        $this->productsOrders[] = $productsOrder;

        return $this;
    }

    /**
     * Remove productsOrder
     *
     * @param \AppBundle\Entity\ProductOrder $productsOrder
     */
    public function removeProductsOrder(\AppBundle\Entity\ProductOrder $productsOrder)
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
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Product
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $uploadedFile
     * @return Product
     */
    public function setUploadedFile($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }
}
