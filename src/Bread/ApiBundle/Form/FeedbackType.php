<?php

namespace Bread\ApiBundle\Form;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class FeedbackType extends FormService
{
    /**
     * @param FormBuilder $builder
     * @return void
     */
    public function createForm(FormBuilder $builder)
    {
        $builder
            ->add('Name', [
                'constraints'   =>  [
                    new NotBlank(['message' => 'Введите ФИО'])
                ]
            ])
            ->add('Phone', [
                'constraints'   =>  [
                    new NotBlank(['message' => 'Введите телефон']),
                    new Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Неверно введен телефон'
                    ])
                ]
            ])
            ->add('Email', [
                'constraints'   =>  [
                    new NotBlank(['message' =>  'Введите E-mail']),
                    new Email(['message'    =>  'E-mail введен неверно'])
                ]
            ])
            ->add('Agree', [
                'constraints'   =>  [
                    new NotBlank(['message' => 'Необходимо согласиться с условиями']),
                    new IsTrue(['message' => 'Необходимо согласиться с условиями'])
                ]
            ]);

        $data = $builder->createForm();
        $data->add('Comment');

        $builder->add('Data', $data);
    }
}