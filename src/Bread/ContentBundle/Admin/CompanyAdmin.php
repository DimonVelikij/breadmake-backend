<?php

namespace Bread\ContentBundle\Admin;

use Bread\ContentBundle\Form\Type\Admin\CompanyAdditionalType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CompanyAdmin extends AbstractAdmin
{
    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('delete')
            ->remove('batch')
            ->remove('export')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, [
                'label'     => 'Название',
                'sortable'  =>  false
            ])
            ->add('phone', null, [
                'label'     => 'Телефон',
                'sortable'  =>  false
            ])
            ->add('email', null, [
                'label'     =>  'E-mail',
                'sortable'  =>  false
            ])
            ->add('address', null, [
                'label'     =>  'Адрес',
                'sortable'  =>  false
            ])
            ->add('_action', null, array(
                'label'     =>  'Действия',
                'actions'   => array(
                    'show' => array(),
                    'edit' => array()
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Основное')
                ->with('Основные данные')
                    ->add('title', null, [
                        'label'     =>  'Название',
                        'required'  =>  true
                    ])
                    ->add('phone', null, [
                        'label'     =>  'Телефон',
                        'required'  =>  true
                    ])
                    ->add('email', null, [
                        'label'     =>  'E-mail',
                        'required'  =>  false
                    ])
                    ->add('address', null, [
                        'label'     =>  'Адрес',
                        'required'  =>  true
                    ])
                ->end()
            ->end()
            ->tab('Дополнительно')
                ->with('Дополнительная информация')
                    ->add('data', CompanyAdditionalType::class, [
                        'label'     =>  false,
                        'required'  =>  false
                    ])
                ->end()
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', null, [
                'label' =>  'Название'
            ])
            ->add('phone', null, [
                'label' =>  'Телефон'
            ])
            ->add('email', null, [
                'label' =>  'E-mail'
            ])
            ->add('address', null, [
                'label' =>  'Адрес'
            ])
            ->add('data', null, [
                'label'     =>  'Дополнительные данные',
                'template'  =>  'BreadContentBundle:Admin:company_additional.html.twig'
            ])
        ;
    }
}
