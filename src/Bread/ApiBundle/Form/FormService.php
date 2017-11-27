<?php

namespace Bread\ApiBundle\Form;

use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\RecursiveValidator;

abstract class FormService implements FormInterface
{
    /** @var RecursiveValidator  */
    private $validator;

    /** @var CsrfTokenManager  */
    private $tokenManager;

    /** @var FormBuilder  */
    private $formBuilder;

    /** @var  array */
    private $formData = [];

    /** @var  array */
    private $formErrors = [];

    /**
     * FormService constructor.
     * @param RecursiveValidator $validator
     * @param CsrfTokenManager $tokenManager
     * @param FormBuilder $formBuilder
     */
    public function __construct(
        RecursiveValidator $validator,
        CsrfTokenManager $tokenManager,
        FormBuilder $formBuilder
    ) {
        $this->validator = $validator;
        $this->tokenManager = $tokenManager;
        $this->formBuilder = $formBuilder;
    }

    /**
     * @param ParamFetcher $paramFetcher
     */
    public function handleRequest(ParamFetcher $paramFetcher)
    {
        $this->formData = $paramFetcher->all();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isValid()
    {
        $this->createForm($this->formBuilder);

        /** @var FormBuilder $form */
        $form = $this->formBuilder->getForm();

        if (!isset($this->formData['Token'])) {
            throw new \Exception("Undefined token");
        }

        $token = $this->formData['Token'];

        if (!$this->tokenManager->isTokenValid(new CsrfToken('form', $token))) {
            throw new \Exception("Invalid request token");
        }

        $this->validate($form, $this->formData);

        return count($this->formErrors) ? false : true;
    }

    /**
     * @param FormBuilder $form
     * @param $formData
     * @throws \Exception
     */
    private function validate(FormBuilder $form, $formData)
    {
        foreach ($form->getFormFields() as $fieldName => $fieldParams) {

            if (!array_key_exists($fieldName, $formData)) {
                throw new \Exception("Undefined field '{$fieldName}'");
            }

            $fieldValue = $formData[$fieldName];

            if ($fieldParams instanceof FormBuilder) {
                $this->validate($fieldParams, $formData[$fieldName][0]);
            } else {
                foreach ($fieldParams['constraints'] as $constraint) {
                    $validationResult = $this->validator->validate($fieldValue, $constraint);

                    if (count($validationResult)) {
                        /** @var ConstraintViolation $constraintViolation */
                        $constraintViolation = $validationResult[0];
                        $this->formErrors[$fieldName] = $constraintViolation->getMessage();
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getFormErrors()
    {
        return $this->formErrors;
    }

    abstract function createForm(FormBuilder $builder);
}