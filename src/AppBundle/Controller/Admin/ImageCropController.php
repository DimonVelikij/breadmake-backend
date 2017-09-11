<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Image;
use AppBundle\ImageCropService\UploadCropFile;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ImageCropController extends CRUDController
{
    /**
     * удаление изображения
     * @param $id
     * @param null $imageId
     * @return RedirectResponse
     */
    public function removeImageCropAction($id, $imageId = null)
    {
        $object = $this->admin->getObject($id);
        $classPathParts = explode('\\', get_class($object));
        $entityName = strtolower(array_pop($classPathParts));

        /** @var UploadCropFile $uploadCropFile */
        $uploadCropFile = $this->container->get('app.upload_crop_file');

        if ($imageId) {
            $images = $object->getImages();
            if (count($images)) {
                $image = null;
                /** @var Image $removedImage */
                foreach ($images as $removedImage) {
                    if ($removedImage->getId() == $imageId) {
                        $image = $removedImage;
                        break;
                    }
                }
                if ($image) {
                    $object->removeImage($image);
                    $this->admin->update($object);
                    $uploadCropFile->clearImageDir($id, $entityName, $image);
                }
                if (!count($object->getImages())) {
                    $object->setImageCrop(null);
                }
            }
        } else {
            $image = $object->getImage();
            $object->setImage(null);
            $object->setImageCrop(null);
            $this->admin->update($object);
            $uploadCropFile->clearImageDir($id, $entityName, $image);
        }

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('sonata_flash_success', 'Изображение успешно удалено');

        return new RedirectResponse($this->admin->generateUrl('edit', ['id' => $id]));
    }
}