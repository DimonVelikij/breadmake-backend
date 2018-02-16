<?php

namespace Bread\ApiBundle\Form;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class OrderType extends BaseFormType
{
    /**
     * @param FormBuilder $builder
     * @return void
     */
    public function createForm(FormBuilder $builder)
    {
        parent::createForm($builder);

        $data = $builder->createForm();
        $data
            ->add('Delivery', [
                'constraints'   =>  []
            ])
            ->add('PreferenceDate', [
                'constraints'   =>  [
                    new NotBlank(['message' => 'Введите предпочитаемую дату заказа']),
                    new Regex([
                        'pattern'   =>  '/^([0-2]\d|3[01])\.(0\d|1[012])\.(20)(1[8-9]|2\d)$/',
                        'message'   =>  'Неверно введена дата'
                    ])
                ]
            ])
            ->add('CartContent', [
                'constraints'   =>  [
                    new NotBlank(['message' => 'Не выбраны товары'])
                ]
            ])
            ->add('Address', [
                'constraints'   =>  []
            ]);

        $builder->add('Data', $data);
    }
}