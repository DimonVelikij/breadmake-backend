<?php

namespace Bread\ContentBundle\Admin;

use Bread\ContentBundle\Entity\Declaration;
use Bread\ContentBundle\Form\Type\ImageCropType;
use Bread\ContentBundle\ImageCropService\ImageCrop;
use Bread\ContentBundle\ImageCropService\UploadCropFile;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sonata\AdminBundle\Route\RouteCollection;

class DeclarationAdmin extends AbstractAdmin
{
    use AdminTrait;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('remove_image_crop', $this->getRouterIdParameter() . '/remove_image_crop');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, [
                'label' =>  'Название'
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title', null, [
                'label' =>  'Название'
            ])
            ->add('image', 'boolean', [
                'label' =>  'Изображение'
            ])
            ->add('_action', null, array(
                'label'     =>  'Действия',
                'actions'   =>  array(
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isNew = !$this->getSubject()->getId();

        /** @var ImageCrop $imageCropService */
        $imageCropService = $this->getContainer()->get('bread_content.image_crop');

        $formMapper
            ->add('title', null, [
                'label'     =>  'Название',
                'required'  =>  true
            ])
            ->add('description', CKEditorType::class, [
                'label'     =>  'Описание',
                'required'  =>  false
            ])
        ;

        if (!$isNew) {
            $formMapper
                ->add('uploadedFile', ImageCropType::class, [
                    'label'         =>  'Изображение',
                    'required'      =>  false,
                    'entity'        =>  'declaration',
                    'constraints'   =>  $imageCropService->getImageConstraints('declaration')
                ])
                ->add('imageCrop', HiddenType::class, [
                    'attr'  =>  [
                        'crop'    =>  'image'
                    ]
                ]);
        }
    }

    public function preUpdate($object)
    {
        $originalObject = $this->getOriginalObject($object);

        /** @var UploadCropFile $uploadCropFile */
        $uploadCropFile = $this->getContainer()->get('bread_content.upload_crop_file');

        if ($object->getUploadedFile() instanceof UploadedFile) {
            $image = $uploadCropFile->uploadFile($object->getId(), 'declaration', $object->getUploadedFile(), $object->getImage());
            $object->setImage($image);
            $object->setImageCrop(json_encode($uploadCropFile->getImageCropParams()));
        } elseif ($object->getImage() && $originalObject['imageCrop'] != $object->getImageCrop()) {
            $image = $uploadCropFile->cropImage($object->getId(), 'declaration', $object->getImage(), json_decode($object->getImageCrop(), true));
            $object->setImage($image);
        }
    }

    public function preRemove($object)
    {
        if ($object instanceof Declaration) {
            /** @var UploadCropFile $uploadCropFile */
            $uploadCropFile = $this->getContainer()->get('bread_content.upload_crop_file');
            $uploadCropFile->clearImageDir($object->getId(), 'declaration', $object->getImage());
        }
    }
}
