<?php

namespace Bread\ApiBundle\Form;

class FeedbackType extends BaseFormType
{
    /**
     * @param FormBuilder $builder
     * @return void
     */
    public function createForm(FormBuilder $builder)
    {
        parent::createForm($builder);

        $data = $builder->createForm();
        $data->add('Comment');

        $builder->add('Data', $data);
    }
}