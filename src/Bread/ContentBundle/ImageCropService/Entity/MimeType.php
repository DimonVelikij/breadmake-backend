<?php

namespace Bread\ContentBundle\ImageCropService\Entity;

/**
 * класс для работы с mime типами файлов
 * Class MimeType
 * @package Bread\ContentBundle\ImageCropService\Entity
 */
class MimeType
{
    /**
     * название типа
     * @var string
     */
    private $name;

    /**
     * MimeType constructor.
     * @param string $mimeTypeName
     */
    public function __construct(string $mimeTypeName)
    {
        $this->name = $mimeTypeName;
    }

    /**
     * получение названия типа
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}