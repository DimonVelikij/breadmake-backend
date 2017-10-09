<?php

namespace Bread\ContentBundle\ImageCropService;

use Bread\ContentBundle\Entity\Image;
use Bread\ContentBundle\ImageCropService\Entity\ImageCropEntity;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadCropFile
{
    /** максимальная ширина области просмотра */
    const MAX_SHOW_WIDTH = 600;

    /** ширина просмотра превью и обрезанного изоббражения */
    const SHOW_CROP_PREVIEW_WIDTH = 250;

    /** @var  array */
    private $imageCropParams;

    /** @var ImageCrop  */
    private $imageCrop;

    /** @var EntityManager  */
    private $em;

    /**
     * UploadCropFile constructor.
     * @param ImageCrop $imageCrop
     * @param EntityManager $em
     */
    public function __construct(ImageCrop $imageCrop, EntityManager $em)
    {
        $this->imageCrop = $imageCrop;
        $this->em = $em;
    }

    /**
     * загрузка файла
     * @param int $entityId
     * @param string $entityName
     * @param UploadedFile $file
     * @param Image|null $image
     * @return Image
     * @throws \Exception
     */
    public function uploadFile(int $entityId, string $entityName, UploadedFile $file, Image $image = null) 
    {
        $fileExtension = $file->guessExtension();
        
        $fullEntityDir = "{$this->imageCrop->getSaveDir()}/{$entityName}";
        $fullImageDir = "{$fullEntityDir}/{$entityId}";

        $assetEntityDir = "{$this->imageCrop->getAssetDir()}/{$entityName}";
        $assetImageDir = "{$assetEntityDir}/{$entityId}";

        if ($image) {
            //если файл уже есть, удаляем его
            $this->clearImageDir($entityId, $entityName, $image);
        }

        //установка параметров кропа
        $this->imageCropParams = $this->setImageCropParams($file, $entityName);

        //название оригинального изображения
        $fileName = md5(uniqid()).'.'.$fileExtension;
        $file->move($fullImageDir, $fileName);
        chmod($fullEntityDir, 0777);
        chmod($fullImageDir, 0777);
        chmod($fullImageDir.'/'.$fileName, 0777);

        $image = new Image();
        $image->setFileName($fileName);
        $image->setPath($fullImageDir . '/' . $fileName);
        $image->setExtension($fileExtension);
        $image->setAssetPath($assetImageDir . '/' . $fileName);
        $image->setCreatedAt(new \DateTime());

        $image = $this->cropImage($entityId, $entityName, $image, $this->imageCropParams);

        return $image;
    }

    /**
     * обрезка изображения
     * @param int $entityId
     * @param string $entityName
     * @param Image $image
     * @param array $imageCropParams
     * @return Image
     * @throws \Exception
     */
    public function cropImage(int $entityId, string $entityName, Image $image, array $imageCropParams)
    {
        $cropFunctionExtension = 'crop' . ucfirst($image->getExtension());

        if (!method_exists($this, $cropFunctionExtension)) {
            throw new \Exception('Не найден метод ' . $cropFunctionExtension);
        }

        if (file_exists($image->getCropPath())) {
            unlink($image->getCropPath());
        }

        $cropFileName = md5(uniqid()).'.'.$image->getExtension();
        $fullEntityDir = "{$this->imageCrop->getSaveDir()}/{$entityName}/{$entityId}";
        $assetEntityDir = "{$this->imageCrop->getAssetDir()}/{$entityName}/{$entityId}";

        $image->setCropFileName($cropFileName);
        $image->setCropPath($fullEntityDir . '/' . $cropFileName);
        $image->setAssetCropPath($assetEntityDir . '/' . $cropFileName);
        $this->imageCropParams = $imageCropParams;

        try {
            $image = $this->$cropFunctionExtension($image);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        if (!$image) {
            throw new \Exception('Ошибка кропа изображения');
        }

        $this->em->persist($image);

        return $image;
    }

    /**
     * @param Image $image
     * @return Image
     * @throws \Exception
     */
    public function cropPng(Image $image)
    {
        $originalImage = @imagecreatefrompng("{$image->getPath()}");

        if (!$originalImage) {
            throw new \Exception("Неудалось создать оригинальное изображение для обрезки png");
        }

        $imageCropParams = $this->getImageCropParams();

        $cropImage = imagecreatetruecolor($imageCropParams['cropWidth'], $imageCropParams['cropHeight']);
        imagealphablending($cropImage, false);
        imagesavealpha($cropImage, true);
        $transparent = imagecolorallocatealpha($cropImage, 255,255,255,127);
        imagefilledrectangle(
            $cropImage, 0, 0,
            $imageCropParams['cropWidth'],
            $imageCropParams['cropHeight'],
            $transparent
        );
        imagecopyresampled(
            $cropImage, $originalImage,
            0, 0,
            $imageCropParams['x1'], $imageCropParams['y1'],
            $imageCropParams['cropWidth'], $imageCropParams['cropHeight'],
            ($imageCropParams['x2'] - $imageCropParams['x1']), ($imageCropParams['y2'] - $imageCropParams['y1'])
        );
        imagepng($cropImage, "{$image->getCropPath()}");
        imagedestroy($originalImage);
        imagedestroy($cropImage);
        chmod("{$image->getCropPath()}", 0777);

        return $image;
    }

    /**
     * @param Image $image
     * @return Image
     * @throws \Exception
     */
    public function cropJpeg(Image $image) {
        $originalImage = @imagecreatefromjpeg("{$image->getPath()}");

        if (!$originalImage) {
            throw new \Exception("Неудалось создать оригинальное изображение для обрезки jpeg");
        }

        $imageCropParams = $this->getImageCropParams();

        $cropImage = imagecreatetruecolor($imageCropParams['cropWidth'], $imageCropParams['cropHeight']);
        imagecopyresampled(
            $cropImage, $originalImage,
            0, 0,
            $imageCropParams['x1'], $imageCropParams['y1'],
            $imageCropParams['cropWidth'], $imageCropParams['cropHeight'],
            ($imageCropParams['x2'] - $imageCropParams['x1']), ($imageCropParams['y2'] - $imageCropParams['y1'])
        );
        imagejpeg($cropImage, "{$image->getCropPath()}");
        imagedestroy($originalImage);
        imagedestroy($cropImage);
        chmod("{$image->getCropPath()}", 0777);

        return $image;
    }

    /**
     * получение максимальных координат для обрезки
     * @param int $originalWidth
     * @param int $originalHeight
     * @param ImageCropEntity $imageCropEntity
     * @return array
     */
    private function getMaxCropCoordinates(
        int $originalWidth,
        int $originalHeight,
        ImageCropEntity $imageCropEntity
    ) {
        $aspectRatioCrop = $imageCropEntity->getCropSize()->getWidth() / $imageCropEntity->getCropSize()->getHeight();

        if ((int)($originalWidth / $aspectRatioCrop) <= $originalHeight) {
            $maxImageCrop = [
                'width'     =>  $originalWidth,
                'height'    =>  (int)($originalWidth / $aspectRatioCrop)
            ];
        } else {
            $maxImageCrop = [
                'width'     =>  (int)($originalHeight * $aspectRatioCrop),
                'height'    =>  $originalHeight
            ];
        }

        return $maxImageCrop;
    }

    /**
     * установка параметров кропа
     * @param UploadedFile $file
     * @param string $entityName
     * @return array
     */
    public function setImageCropParams(UploadedFile $file, string $entityName)
    {
        list($originalWidth, $originalHeight) = getimagesize($file);

        /** @var ImageCropEntity $entityParams */
        $imageCropEntity = $this->imageCrop->getEntity($entityName);

        $maxCropCoordinates = $this->getMaxCropCoordinates($originalWidth, $originalHeight, $imageCropEntity);

        $params = [
            'maxShowWidth'          =>  self::MAX_SHOW_WIDTH,
            'showCropPreviewWidth'  =>  self::SHOW_CROP_PREVIEW_WIDTH,
            'width'                 =>  $originalWidth,
            'height'                =>  $originalHeight,
            'cropWidth'             =>  $imageCropEntity->getCropSize()->getWidth(),
            'cropHeight'            =>  $imageCropEntity->getCropSize()->getHeight(),
            'x1'                    =>  0,
            'y1'                    =>  0,
            'x2'                    =>  $maxCropCoordinates['width'],
            'y2'                    =>  $maxCropCoordinates['height']
        ];

        return $params;
    }

    /**
     * получение параметров кропа
     * @return array
     */
    public function getImageCropParams()
    {
        return $this->imageCropParams;
    }

    /**
     * очистка папки с картинкой
     * @param int $entityId
     * @param string $entityName
     * @param Image|null $image
     */
    public function clearImageDir(int $entityId, string $entityName, Image $image = null)
    {
        $entityDir = "{$this->imageCrop->getSaveDir()}/{$entityName}";
        $imageDir = "{$entityDir}/{$entityId}";
        
        if ($image) {
            $originalImage = $image->getPath();
            $cropImage = $image->getCropPath();
            if (file_exists($originalImage)) {
                unlink($originalImage);
            }
            if (file_exists($cropImage)) {
                unlink($cropImage);
            }
            $this->em->remove($image);
        }

        if (is_dir($imageDir) && !glob($imageDir.'/*')) {
            rmdir($imageDir);
        }

        if (is_dir($entityDir) && !glob($entityDir.'/*')) {
            rmdir($entityDir);
        }
    }
}