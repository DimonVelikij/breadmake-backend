<?php

namespace AppBundle\ImageCropService\Entity;

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