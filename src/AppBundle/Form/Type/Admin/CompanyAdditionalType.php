<?php

namespace AppBundle\Form\Type\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CompanyAdditionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('working_days', TextType::class, [
                'label'     =>  'Время работы',
                'required'  =>  false,
                'attr'      =>  [
                    'placeholder'   =>  '08:00-17:00'
                ]
            ])
            ->add('weekend', TextType::class, [
                'label'     =>  'Выходные',
                'required'  =>  false,
                'attr'      =>  [
                    'placeholder'   =>  'сб-вс'
                ]
            ])
            ->add('delivery', CKEditorType::class, [
                'label'     =>  'Доставка',
                'required'  =>  false
            ])
            ->add('payment', CKEditorType::class, [
                'label'     =>  'Оплата',
                'required'  =>  false
            ])
        ;
    }
}