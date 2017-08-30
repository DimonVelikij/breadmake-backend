<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Menu
 * @package AppBundle\Entity
 * @ORM\Table(name="menu")
 * @ORM\Entity
 */
class Menu
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
     * @var boolean $public
     *
     * @ORM\Column(name="public", type="boolean", nullable=false, options={"default": true})
     */
    private $public;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

    /**
     * @var string $configs
     *
     * @ORM\Column(name="configs", type="object", nullable=true)
     */
    private $configs;

    /**
     * @var int
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="sortable_rank", type="integer")
     */
    protected $sortableRank;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?? '';
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
     * @return Menu
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
     * Set public
     *
     * @param boolean $public
     *
     * @return Menu
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
     * Set path
     *
     * @param string $path
     *
     * @return Menu
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set configs
     *
     * @param string $configs
     *
     * @return Menu
     */
    public function setConfigs($configs)
    {
        $this->configs = $configs;

        return $this;
    }

    /**
     * Get configs
     *
     * @return string
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * Set sortableRank
     *
     * @param integer $sortableRank
     *
     * @return Menu
     */
    public function setSortableRank($sortableRank)
    {
        $this->sortableRank = $sortableRank;

        return $this;
    }

    /**
     * Get sortableRank
     *
     * @return integer
     */
    public function getSortableRank()
    {
        return $this->sortableRank;
    }
}
