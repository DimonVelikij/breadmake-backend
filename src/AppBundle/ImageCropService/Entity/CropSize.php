<?php

namespace AppBundle\ImageCropService\Entity;

class CropSize
{
    /**
     * ширина обрезанного изображения
     * @var integer
     */
    private $width;

    /**
     * высота обрезанного изображения
     * @var integer
     */
    private $height;

    /**
     * CropSize constructor.
     * @param array $cropSize
     */
    public function __construct(array $cropSize)
    {
        $this->width = isset($cropSize['width']) ? $cropSize['width'] : null;
        $this->height = isset($cropSize['height']) ? $cropSize['height'] : null;
    }

    /**
     * получение ширины обрезанного изображения
     * @return null|integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * получение высоты обрезанного изображения
     * @return null|integer
     */
    public function getHeight()
    {
        return $this->height;
    }
}