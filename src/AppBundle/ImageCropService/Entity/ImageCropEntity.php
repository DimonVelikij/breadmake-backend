<?php

namespace AppBundle\ImageCropService\Entity;

/**
 * класс для работы с сущностями кропов
 * Class ImageCropEntity
 * @package AppBundle\Service
 */
class ImageCropEntity
{
    /**
     * название сущности
     * @var string
     */
    private $name;

    /**
     * минимальная ширина
     * @var int
     */
    private $minWidth;

    /**
     * минимальная высота
     * @var int
     */
    private $minHeight;

    /**
     * максимальная ширина
     * @var int
     */
    private $maxWidth;

    /**
     * максимальная высота
     * @var int
     */
    private $maxHeight;

    /**
     * параметры кропа
     * @var CropSize
     */
    private $cropSize;

    /**
     * массив типов
     * @var array
     */
    private $mimeTypes;

    /**
     * минимальное число загружаемых изображений
     * @var int
     */
    private $minCount;

    /**
     * максимльное число загружаемых изображений
     * @var int
     */
    private $maxCount;

    /**
     * ImageCropEntity constructor.
     * @param string $name
     * @param array $params
     */
    public function __construct(string $name, array $params)
    {
        $this->name = $name;
        $this->minWidth = $params['min_width'];
        $this->minHeight = $params['min_height'];
        $this->maxWidth = isset($params['max_width']) ? $params['max_width'] : null;
        $this->maxHeight = isset($params['max_height']) ? $params['max_height'] : null;
        $this->cropSize = new CropSize($params['crop_size']);
        $this->mimeTypes = $params['mime_types'];
        $this->minCount = $params['min_count'];
        $this->maxCount = $params['max_count'];
    }

    /**
     * получение названия сущности
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * получение минимальной ширины
     * @return int
     */
    public function getMinWidth()
    {
        return $this->minWidth;
    }

    /**
     * получение минимальной высоты
     * @return int
     */
    public function getMinHeight()
    {
        return $this->minHeight;
    }

    /**
     * получение максимальной ширины
     * @return int|null
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * получение максимальной высоты
     * @return int|null
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * получение параметров кропа
     * @return CropSize
     */
    public function getCropSize()
    {
        return $this->cropSize;
    }

    /**
     * получение массива типов
     * @return array
     */
    public function getMimeType()
    {
        $mimeTypes = [];
        if (count($this->mimeTypes)) {
            for ($i = 0; $i < count($this->mimeTypes); $i++) {
                $mimeType = new MimeType($this->mimeTypes[$i]);
                $mimeTypes[] = $mimeType;
            }
        }

        return $mimeTypes;
    }

    /**
     * получение минимального количество загружаемых изображений
     * @return int
     */
    public function getMinCount()
    {
        return $this->minCount;
    }

    /**
     * получение максимального количества загружаемых изображений
     * @return int
     */
    public function getMaxCount()
    {
        return $this->maxCount;
    }
}