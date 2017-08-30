<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Image;
use AppBundle\Entity\News;
use AppBundle\Form\Type\ImageCropType;
use AppBundle\ImageCropService\ImageCrop;
use AppBundle\ImageCropService\UploadCropFile;
use Doctrine\ORM\EntityManager;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sonata\AdminBundle\Route\RouteCollection;

class NewsAdmin extends AbstractAdmin
{
    use AdminTrait;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('remove_image_crop', $this->getRouterIdParameter() . '/remove_image_crop/{imageId}');
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
                'label'     =>  'Показано на сайте',
                'sortable'  =>  false
            ])
            ->add('createdAt', null, [
                'label' =>  'Создано'
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
            ]);

        if (!$isNew) {
            $formMapper
                ->add('uploadedFiles', ImageCropType::class, [
                    'label'         => 'Изображения',
                    'required'      => false,
                    'multiple'      => true,
                    'entity'        => 'news',
                    'constraints'   =>  $imageCropService->getMultipleImageConstraints('news')
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
        /** @var UploadCropFile $uploadCropFile */
        $uploadCropFile = $this->getContainer()->get('app.upload_crop_file');

        if (count($object->getUploadedFiles())) {
            foreach ($object->getUploadedFiles() as $uploadedFile) {
                if (!$uploadedFile instanceof UploadedFile) {
                    continue;
                }
                $image = $uploadCropFile->uploadFile($object->getId(), 'news', $uploadedFile, null);
                $object->addImage($image);
                $object->setImageCrop(json_encode($uploadCropFile->getImageCropParams()));
            }
        }
    }

    public function preRemove($object)
    {
        if ($object instanceof News) {
            /** @var UploadCropFile $uploadCropFile */
            $uploadCropFile = $this->getContainer()->get('app.upload_crop_file');
            $images = clone $object->getImages();
            if (count($images)) {
                //сначала нужно удалить связки с картинками, потом сами картинки
                /** @var Image $image */
                foreach ($images as $image) {
                    $object->removeImage($image);
                }
                /** @var EntityManager $em */
                $em = $this->getContainer()->get('doctrine.orm.entity_manager');
                $em->persist($object);
                $em->flush();
                /** @var Image $image */
                foreach ($images as $image) {
                    $uploadCropFile->clearImageDir($object->getId(), 'news', $image);
                }
            }
        }
    }
}
