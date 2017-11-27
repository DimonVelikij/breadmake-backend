<?php

namespace Bread\ApiBundle\Form;

use FOS\RestBundle\Request\ParamFetcher;

interface FormInterface
{
    /**
     * @param FormBuilder $builder
     * @return void
     */
    public function createForm(FormBuilder $builder);

    /**
     * @param ParamFetcher $paramFetcher
     * @return void
     */
    public function handleRequest(ParamFetcher $paramFetcher);

    /**
     * @return bool
     */
    public function isValid();

    /**
     * @return array
     */
    public function getFormErrors();
}