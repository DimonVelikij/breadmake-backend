<?php

namespace Bread\ApiBundle\Form;

class FormBuilder
{
    /** @var  array */
    private $form;

    /**
     * @param $fieldName
     * @param null $fieldParams
     * @return FormBuilder
     */
    public function add($fieldName, $fieldParams = null)
    {
        $this->form[$fieldName] = $fieldParams ?? $this->getDefaultFieldParams();

        return $this;
    }

    /**
     * @return FormBuilder
     */
    public function getForm()
    {
        return $this;
    }

    /**
     * @return array
     */
    public function getFormFields()
    {
        return $this->form;
    }

    /**
     * @return FormBuilder
     */
    public function createForm()
    {
        return new FormBuilder();
    }

    /**
     * @return array
     */
    private function getDefaultFieldParams()
    {
        return [
            'constraints'   =>  []
        ];
    }
}