<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Slide;
use AppBundle\Form\Type\ImageCropType;
use AppBundle\ImageCropService\ImageCrop;
use AppBundle\ImageCropService\UploadCropFile;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SlideAdmin extends AbstractAdmin
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
            ->add('public', null, [
                'label' =>  'Показано на сайте'
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
            ->add('public', null, [
                'label' =>  'Показано на сайте'
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
        $imageCropService = $this->getContainer()->get('app.image_crop');

        $formMapper
            ->add('title', null, [
                'label'     =>  'Название',
                'required'  =>  true
            ])
            ->add('description', CKEditorType::class, [
                'label'     =>  'Описание',
                'required'  =>  false
            ])
            ->add('public', null, [
                'label'     =>  'Показать на сайте',
                'required'  =>  false
            ])
        ;

        if (!$isNew) {
            $formMapper
                ->add('uploadedFile', ImageCropType::class, [
                    'label'         =>  'Изображение',
                    'required'      =>  false,
                    'entity'        =>  'slide',
                    'constraints'   =>  $imageCropService->getImageConstraints('slide')
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
        $uploadCropFile = $this->getContainer()->get('app.upload_crop_file');

        if ($object->getUploadedFile() instanceof UploadedFile) {
            $image = $uploadCropFile->uploadFile($object->getId(), 'slide', $object->getUploadedFile(), $object->getImage());
            $object->setImage($image);
            $object->setImageCrop(json_encode($uploadCropFile->getImageCropParams()));
        } elseif ($object->getImage() && $originalObject['imageCrop'] != $object->getImageCrop()) {
            $image = $uploadCropFile->cropImage($object->getId(), 'slide', $object->getImage(), json_decode($object->getImageCrop(), true));
            $object->setImage($image);
        }
    }

    public function preRemove($object)
    {
        if ($object instanceof Slide) {
            /** @var UploadCropFile $uploadCropFile */
            $uploadCropFile = $this->getContainer()->get('app.upload_crop_file');
            $uploadCropFile->clearImageDir($object->getId(), 'slide', $object->getImage());
        }
    }
}
