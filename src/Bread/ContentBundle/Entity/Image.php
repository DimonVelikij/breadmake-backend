<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Photo
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="images")
 * @ORM\Entity
 */
class Image
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
     * @var string $fileName
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=false)
     */
    private $fileName;

    /**
     * @var string $cropFileName
     *
     * @ORM\Column(name="crop_file_name", type="string", length=255, nullable=false)
     */
    private $cropFileName;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

    /**
     * @var string $cropPath
     *
     * @ORM\Column(name="crop_path", type="string", length=255, nullable=false)
     */
    private $cropPath;

    /**
     * @var string $assetPath
     *
     * @ORM\Column(name="asset_path", type="string", length=255, nullable=false)
     */
    private $assetPath;

    /**
     * @var string $assetCropPath
     *
     * @ORM\Column(name="asset_crop_path", type="string", length=255, nullable=false)
     */
    private $assetCropPath;

    /**
     * @var string $extension
     *
     * @ORM\Column(name="extension", type="string", length=255, nullable=false)
     */
    private $extension;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Image
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set cropFileName
     *
     * @param string $cropFileName
     *
     * @return Image
     */
    public function setCropFileName($cropFileName)
    {
        $this->cropFileName = $cropFileName;

        return $this;
    }

    /**
     * Get cropFileName
     *
     * @return string
     */
    public function getCropFileName()
    {
        return $this->cropFileName;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Image
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
     * Set cropPath
     *
     * @param string $cropPath
     *
     * @return Image
     */
    public function setCropPath($cropPath)
    {
        $this->cropPath = $cropPath;

        return $this;
    }

    /**
     * Get cropPath
     *
     * @return string
     */
    public function getCropPath()
    {
        return $this->cropPath;
    }

    /**
     * Set assetPath
     *
     * @param string $assetPath
     *
     * @return Image
     */
    public function setAssetPath($assetPath)
    {
        $this->assetPath = $assetPath;

        return $this;
    }

    /**
     * Get assetPath
     *
     * @return string
     */
    public function getAssetPath()
    {
        return $this->assetPath;
    }

    /**
     * Set assetCropPath
     *
     * @param string $assetCropPath
     *
     * @return Image
     */
    public function setAssetCropPath($assetCropPath)
    {
        $this->assetCropPath = $assetCropPath;

        return $this;
    }

    /**
     * Get assetCropPath
     *
     * @return string
     */
    public function getAssetCropPath()
    {
        return $this->assetCropPath;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Image
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
}
