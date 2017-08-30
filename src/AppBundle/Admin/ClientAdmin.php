<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ClientAdmin extends AbstractAdmin
{
    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('edit')
            ->remove('batch')
            ->remove('delete')
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, [
                'label' =>  'ФИО'
            ])
            ->add('phone', null, [
                'label' =>  'Телефон'
            ])
            ->add('email')
            ->add('isRegistration', null, [
                'label'     =>  'Зарегистрирован на сайте'
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'sortable'  =>  false
            ])
            ->add('name', null, [
                'label' =>  'ФИО'
            ])
            ->add('phone', null, [
                'label'     =>  'Телефон',
                'sortable'  =>  false
            ])
            ->add('email', null, [
                'sortable'  =>  false
            ])
            ->add('isRegistration', null, [
                'label'     =>  'Зарегистрирован на сайте',
                'sortable'  =>  false
            ])
            ->add('countOrders', null, [
                'label'     =>  'Количество заказов',
                'sortable'  =>  false
            ])
            ->add('createdAtFormat', null, [
                'label'     =>  'Создан'
            ])
            ->add('updatedAtFormat', null, [
                'label' =>  'Обновлен'
            ])
            ->add('_action', null, array(
                'label'   => 'Действия',
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                ),
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name', null, [
                'label' =>  'ФИО'
            ])
            ->add('phone', null, [
                'label' =>  'Телефон'
            ])
            ->add('email')
            ->add('isRegistration', null, [
                'label'     =>  'Зарегистрирован на сайте'
            ])
            ->add('createdAtFormat', null, [
                'label'     =>  'Создан'
            ])
            ->add('updatedAtFormat', null, [
                'label' =>  'Обновлен'
            ])
            ->add('countOrders', null, [
                'label' =>  'Количество заказов'
            ])
            ->add('orders', null, [
                'label'     =>  'Заказы',
                'template'  =>  'AppBundle:Admin:client_show_order_info.html.twig'
            ])
        ;
    }
}
