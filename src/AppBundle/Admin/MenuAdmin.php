<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Menu;
use AppBundle\Form\Type\Admin\MenuHomepageConfigsTypes;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class MenuAdmin extends AbstractAdmin
{
    use SortableTrait;

    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by'    => 'sortableRank',
    );

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('move', $this->getRouterIdParameter().'/move/{position}')
            ->remove('batch')
            ->remove('export')
            ->remove('delete')
            ->remove('create')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, [
                'label' =>  'Название'
            ])
            ->add('public', null, [
                'label' =>  'Показать на сайте'
            ])
            ->add('path', null, [
                'label'     =>  'Ссылка',
                'template'  =>  'AppBundle:Admin:menu_route.html.twig'
            ])
            ->add('_action', null, array(
                'label'     =>  'Действия',
                'actions'   =>  array(
                    'edit' => array(),
                    'delete' => array(),
                    'move' => array(
                        'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig'
                    )
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var Menu $object */
        $object = $this->getSubject();

        $formMapper
            ->tab('Основное')
                ->with('')
                    ->add('title', null, [
                        'label'     =>  'Название',
                        'required'  =>  true
                    ])
                    ->add('public', null, [
                        'label'     =>  'Показать на сайте',
                        'required'  =>  false
                    ])
                    ->add('path', null, [
                        'label'     =>  'Название роута',
                        'required'  =>  false,
                        'disabled'  =>  true
                    ])
                ->end()
            ->end()
            ->tab('Дополнительные настройки')
                ->with('')
                    ->add('configs', $this->getConfigType($object->getPath()), [
                        'label'     =>  false,
                        'required'  =>  false
                    ])
                ->end()
            ->end()
        ;
    }

    /**
     * получение формы с настройками по названию роута
     * @param string $pathName
     * @return mixed
     */
    private function getConfigType(string $pathName)
    {
        $configTypes = [
            'admin_app_news_list'  =>  MenuHomepageConfigsTypes::class
        ];

        return $configTypes[$pathName];
    }
}