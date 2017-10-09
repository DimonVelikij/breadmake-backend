<?php

namespace Bread\ContentBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class OrderAdmin extends AbstractAdmin
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
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('isDelivery', null, [
                'label' =>  'Доставка'
            ])
            ->add('client', null, [
                'label' =>  'Клиент'
            ])
            ->add('client.phone', null, [
                'label' =>  'Телефон клиента'
            ])
            ->add('client.email', null, [
                'label' =>  'Email клиента'
            ])
            ->add('status', null, [
                'label' =>  'Статус'
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
                'label'     =>  'Номер заказа',
                'sortable'  =>  false
            ])
            ->add('client', null, [
                'label' =>  'Клиент'
            ])
            ->add('client.phone', null, [
                'label'     =>  'Телефон клиента',
                'sortable'  =>  false
            ])
            ->add('client.email', null, [
                'label'     =>  'Email клиента',
                'sortable'  =>  false
            ])
            ->add('status', 'entity', [
                'label'     =>  'Статус',
                'template'  =>  'BreadContentBundle:Admin:status_color_field.html.twig'
            ])
            ->add('preferenceDateFormat', null, [
                'label' =>  'Предпочитаемая дата заказа'
            ])
            ->add('createdAtFormat', null, [
                'label' =>  'Создан'
            ])
            ->add('isDelivery', null, [
                'label'     =>  'Доставка',
                'sortable'  =>  false
            ])
            ->add('address', null, [
                'label'     =>  'Адрес доставки',
                'sortable'  =>  false
            ])
            ->add('_action', null, array(
                'label'   => 'Действия',
                'actions' => array(
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
            ->add('id', null, [
                'label'     =>  'Номер заявки',
                'disabled'  =>  true
            ])
            ->add('client.name', null, [
                'label'     =>  'Клиент',
                'disabled'  =>  true
            ])
            ->add('client.phone', null, [
                'label'     =>  'Телефон клиента',
                'disabled'  =>  true
            ])
            ->add('status', 'entity', [
                'label'     =>  'Сменить статус',
                'class'     =>  'Bread\ContentBundle\Entity\Status',
                'required'  =>  true
            ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id', null, [
                'label' =>  'Номер заказа'
            ])
            ->add('client', null, [
                'label' =>  'Клиент'
            ])
            ->add('client.phone', null, [
                'label' =>  'Телефон клиента'
            ])
            ->add('client.email', null, [
                'label' =>  'Email клиента'
            ])
            ->add('productsOrders', null, [
                'label'     =>  'Заказ',
                'template'  =>  'BreadContentBundle:Admin:order_show_order_info.html.twig'
            ])
        ;
    }
}
