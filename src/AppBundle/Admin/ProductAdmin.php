<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Product;
use AppBundle\Form\Type\ImageCropType;
use AppBundle\ImageCropService\ImageCrop;
use AppBundle\ImageCropService\UploadCropFile;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductAdmin extends AbstractAdmin
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
            ->add('isNew', null, [
                'label' =>  'Новинка'
            ])
            ->add('isPopulation', null, [
                'label' =>  'Популярное'
            ])
            ->add('public', null, [
                'label' =>  'Показать на сайте'
            ])
            ->add('category', null, [
                'label' =>  'Категория'
            ])
            ->add('flour', null, [
                'label' =>  'Сорт муки'
            ])
            ->add('unit', null, [
                'label' =>  'Единица измерения'
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
            ->add('weight', null, [
                'label' =>  'Вес, кг'
            ])
            ->add('price', null, [
                'label' =>  'Цена, руб'
            ])
            ->add('category', 'entity', [
                'label' =>  'Категория'
            ])
            ->add('flour', 'entity', [
                'label' =>  'Сорт муки'
            ])
            ->add('unit', 'entity', [
                'label' =>  'Единица измерения'
            ])
            ->add('isNew', null, [
                'label'     =>  'Новинка',
                'sortable'  =>  false
            ])
            ->add('isPopulation', null, [
                'label'     =>  'Популярное',
                'sortable'  =>  false
            ])
            ->add('public', null, [
                'label'     =>  'Показать на сайте',
                'sortable'  =>  false
            ])
            ->add('image', 'boolean', [
                'label' =>  'Изображение'
            ])
            ->add('createdAt', null, [
                'label'     =>  'Создан'
            ])
            ->add('updatedAt', null, [
                'label' =>  'Обновлен'
            ])
            ->add('_action', null, array(
                'label'     =>  'Действия',
                'actions'   => array(
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

        /** @var Router $router */
        $router = $this->getContainer()->get('router');

        $relationEntities = [
            'category' =>   [
                'repo'  =>  'AppBundle:Category',
                'count' =>  true,
                'route' =>  $router->generate('admin_app_category_create')
            ],
            'flour'    =>   [
                'repo'  =>  'AppBundle:Flour',
                'count' =>  true,
                'route' =>  $router->generate('admin_app_flour_create')
            ],
            'unit'     =>   [
                'repo'  =>  'AppBundle:Unit',
                'count' =>  true,
                'route' =>  $router->generate('admin_app_unit_create')
            ]
        ];

        foreach ($relationEntities as $entityName => $entityParams) {
            $relationEntities[$entityName]['count'] = $this->getDoctrine()->getRepository($entityParams['repo'])
                ->createQueryBuilder($entityName)
                ->select("COUNT($entityName.id)")
                ->getQuery()
                ->getSingleScalarResult();
        }

        /** @var ImageCrop $imageCropService */
        $imageCropService = $this->getContainer()->get('app.image_crop');

        $formMapper
            ->add('title', null, [
                'label'     =>  'Название',
                'required'  =>  true
            ])
            ->add('weight', null, [
                'label'     =>  'Вес',
                'required'  =>  true
            ])
            ->add('price', null, [
                'label'     =>  'Цена',
                'required'  =>  true
            ])
            ->add('category', 'entity', [
                'label'     =>  'Категория',
                'required'  =>  true,
                'class'     =>  'AppBundle\Entity\Category',
                'help'      =>  $relationEntities['category']['count'] ? '' : "<span style='color: red'>Для добавления продукта необходимо <a target='_blank' href='{$relationEntities['category']['route']}'>добавить категорию продукции</a></span>"
            ])
            ->add('flour', 'entity', [
                'label'     =>  'Сорт муки',
                'required'  =>  true,
                'class'     =>  'AppBundle\Entity\Flour',
                'help'      =>  $relationEntities['flour']['count'] ? '' : "<span style='color: red'>Для добавления продукта необходимо <a target='_blank' href='{$relationEntities['flour']['route']}'>добавить сорт муки</a></span>"
            ])
            ->add('unit', 'entity', [
                'label'     =>  'Единица измерения',
                'required'  =>  true,
                'class'     =>  'AppBundle\Entity\Unit',
                'help'      =>  $relationEntities['unit']['count'] ? '' : "<span style='color: red'>Для добавления продукта необходимо <a target='_blank' href='{$relationEntities['unit']['route']}'>добавить единицу измерения</a></span>"
            ])
            ->add('description', CKEditorType::class, [
                'label'     =>  'Описание',
                'required'  =>  false
            ])
            ->add('isNew', null, [
                'label'     =>  'Новинка',
                'required'  =>  false
            ])
            ->add('isPopulation', null, [
                'label'     =>  'Популярное',
                'required'  =>  false
            ])
            ->add('public', null, [
                'label'     =>  'Показать на сайте',
                'required'  =>  false
            ]);

        if (!$isNew) {
            $formMapper
                ->add('uploadedFile', ImageCropType::class, [
                    'label'         =>  'Изображение',
                    'required'      =>  false,
                    'entity'        =>  'product',
                    'constraints'   =>  $imageCropService->getImageConstraints('product')
                ])
                ->add('imageCrop', HiddenType::class, [
                    'attr'  =>  [
                        'crop'    =>  'image'
                    ]
                ]);
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function preUpdate($object)
    {
        $originalObject = $this->getOriginalObject($object);

        /** @var UploadCropFile $uploadCropFile */
        $uploadCropFile = $this->getContainer()->get('app.upload_crop_file');

        if ($object->getUploadedFile() instanceof UploadedFile) {
            $image = $uploadCropFile->uploadFile($object->getId(), 'product', $object->getUploadedFile(), $object->getImage());
            $object->setImage($image);
            $object->setImageCrop(json_encode($uploadCropFile->getImageCropParams()));
        } elseif ($object->getImage() && $originalObject['imageCrop'] != $object->getImageCrop()) {
            $image = $uploadCropFile->cropImage($object->getId(), 'product', $object->getImage(), json_decode($object->getImageCrop(), true));
            $object->setImage($image);
        }
    }

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if ($object instanceof Product) {
            /** @var UploadCropFile $uploadCropFile */
            $uploadCropFile = $this->getContainer()->get('app.upload_crop_file');
            $uploadCropFile->clearImageDir($object->getId(), 'product', $object->getImage());
        }
    }
}
