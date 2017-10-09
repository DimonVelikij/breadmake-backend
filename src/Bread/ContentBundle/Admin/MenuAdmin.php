<?php

namespace Bread\ContentBundle\Admin;

use Bread\ContentBundle\Entity\Menu;
use Bread\ContentBundle\Form\Type\Admin\MenuHomepageConfigsTypes;
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
                'template'  =>  'BreadContentBundle:Admin:menu_route.html.twig'
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
            ->end();
        
        if ($this->isConfigType($object->getPath())) {
            $formMapper
                ->tab('Дополнительные настройки')
                    ->with('')
                        ->add('configs', $this->getConfigType($object->getPath()), [
                            'label' => false,
                            'required' => false
                        ])
                    ->end()
                ->end();
        }
    }

    /**
     * имеет ли текущий раздел доп настройки
     * @param string $pathName
     * @return bool
     */
    private function isConfigType(string $pathName)
    {
        $configTypes = [
            'homepage'
        ];

        return in_array($pathName, $configTypes);
    }

    /**
     * получение формы с настройками по названию роута
     * @param string $pathName
     * @return mixed
     */
    private function getConfigType(string $pathName)
    {
        $configTypes = [
            'homepage'  =>  MenuHomepageConfigsTypes::class,
            //доделать настройки для остальных роутов
        ];

        return $configTypes[$pathName];
    }
}
