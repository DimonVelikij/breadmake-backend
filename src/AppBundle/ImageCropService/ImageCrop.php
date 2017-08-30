<?php

namespace AppBundle\ImageCropService;

use AppBundle\ImageCropService\Entity\ImageCropEntity;
use AppBundle\ImageCropService\Entity\MimeType;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Image;

/**
 * сервис для работы с кропом
 * Class ImageCrop
 * @package AppBundle\Service
 */
class ImageCrop
{
    const MIME_TYPE_PREFIX = 'image';

    /**
     * путь директории сохранения изображения
     * @var string
     */
    private $saveDir;

    /**
     * путь директории для asset
     * @var string
     */
    private $assetDir;

    /**
     * массив сущностей
     * @var array
     */
    private $entities;

    /**
     * ImageCrop constructor.
     * @param string $saveDir
     * @param string $assetDir
     * @param array $entities
     */
    public function __construct(string $saveDir, string $assetDir, array $entities)
    {
        $this->saveDir = $saveDir;
        $this->assetDir = $assetDir;
        $this->entities = $entities;
    }

    /**
     * получение директории сохранения изображений
     * @return string
     */
    public function getSaveDir()
    {
        return $this->saveDir;
    }

    /**
     * получение директории для asset
     * @return string
     */
    public function getAssetDir()
    {
        return $this->assetDir;
    }

    /**
     * получение массива сущностей
     * @return array
     */
    public function getEntities()
    {
        if (!count($this->entities)) {
            return [];
        }

        $entities = [];

        foreach ($this->entities as $entityName => $entityParams) {
            $entity = new ImageCropEntity($entityName, $entityParams);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * получение сущности
     * @param string $entity
     * @return ImageCropEntity|null
     */
    public function getEntity(string $entity)
    {
        if (!isset($this->entities[$entity])) {
            return null;
        }

        return new ImageCropEntity($entity, $this->entities[$entity]);
    }

    /**
     * ограничения для файла
     * @param string $entityName
     * @return array
     */
    public function getImageConstraints(string $entityName)
    {
        /** @var ImageCropEntity $imageCropEntity */
        $imageCropEntity = $this->getEntity($entityName);

        $mimeTypes = [];
        $mimeTypesMessage = [];
        /** @var MimeType $mimeType */
        foreach ($imageCropEntity->getMimeType() as $mimeType) {
            $mimeTypes[] = self::MIME_TYPE_PREFIX . '/' . $mimeType->getName();
            $mimeTypesMessage[] = $mimeType->getName();
        }

        $imageConstraints = [
            'mimeTypes'         =>  $mimeTypes,
            'mimeTypesMessage'  =>  "Допустимые форматы файла: " . implode(',', $mimeTypesMessage) . ".",
            'minWidth'          =>  $imageCropEntity->getMinWidth(),
            'minWidthMessage'   =>  "Минимальная ширина {$imageCropEntity->getMinWidth()}px",
            'minHeight'         =>  $imageCropEntity->getMinHeight(),
            'minHeightMessage'  =>  "Минимальная высота {$imageCropEntity->getMinHeight()}px"
        ];

        if ($imageCropEntity->getMaxWidth() && $imageCropEntity->getMaxHeight()) {
            $imageConstraints['maxWidth'] = $imageCropEntity->getMaxWidth();
            $imageConstraints['maxWidthMessage'] = "Максимальная ширина {$imageCropEntity->getMaxWidth()}px";
            $imageConstraints['maxHeight'] = $imageCropEntity->getMaxHeight();
            $imageConstraints['maxHeightMessage'] = "Максимальная высота {$imageCropEntity->getMaxHeight()}px";
        }

        return new Image($imageConstraints);
    }

    /**
     * ограничения для мультизагрузки файлов
     * @param string $entityName
     * @return All
     */
    public function getMultipleImageConstraints(string $entityName)
    {
        /** @var ImageCropEntity $imageCropEntity */
        $imageCropEntity = $this->getEntity($entityName);

        $countConstraints = [
            'max'           =>  $imageCropEntity->getMaxCount(),
            'maxMessage'    =>  'Максимальное количество загружаемых изображений: ' . $imageCropEntity->getMaxCount()
        ];

        if ($imageCropEntity->getMinCount() > 1) {
            $countConstraints['min'] = $imageCropEntity->getMinCount();
            $countConstraints['minMessage'] = 'Минимальное количество загружаемых изображений: ' . $imageCropEntity->getMinCount();
        }

        $allConstraints = [
            'constraints'   =>  [
                $this->getImageConstraints($entityName)
            ]
        ];

        return [
            new Count($countConstraints),
            new All($allConstraints)
        ];
    }

    /**
     * подсказка для поля загрузки изображения
     * @param string $entityName
     * @return string
     */
    public function getFormHelp(string $entityName)
    {
        /** @var ImageCropEntity $imageCropEntity */
        $imageCropEntity = $this->getEntity($entityName);

        $formHelp = 'Минимальный размер изображения "<b>' . $imageCropEntity->getMinWidth() . 'px x ' . $imageCropEntity->getMinHeight() . 'px</b>"<br>';

        if ($imageCropEntity->getMaxWidth() && $imageCropEntity->getMaxHeight()) {
            $formHelp .= 'Максимальный размер изображения "<b>' . $imageCropEntity->getMaxWidth() . 'px x ' . $imageCropEntity->getMaxHeight() . 'px</b>"<br>';
        }

        $mimeTypes = [];
        /** @var MimeType $mimeType */
        foreach ($imageCropEntity->getMimeType() as $mimeType) {
            $mimeTypes[] = $mimeType->getName();
        }
        $mimeTypes = implode(',', $mimeTypes);

        $formHelp .= 'Доступные форматы изображений "<b>' . $mimeTypes . '</b>"';

        return $formHelp;
    }

    /**
     * подсказка для поля мультизагрузки изображений
     * @param string $entityName
     * @return string
     */
    public function getMultipleFormHelp(string $entityName)
    {
        /** @var ImageCropEntity $imageCropEntity */
        $imageCropEntity = $this->getEntity($entityName);

        $formHelp = $this->getFormHelp($entityName) . '<br>';

        if ($imageCropEntity->getMinCount() > 1) {
            $formHelp .= 'Минимальное количество загружаемых изображений "<b>' . $imageCropEntity->getMinCount() . '</b>"<br>';
        }

        $formHelp .= 'Максимальное количество загружаемых изображений "<b>' . $imageCropEntity->getMaxCount() . '"</b>';

        return $formHelp;
    }
}