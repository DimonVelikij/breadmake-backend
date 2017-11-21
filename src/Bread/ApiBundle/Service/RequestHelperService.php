<?php

namespace Bread\ApiBundle\Service;

use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class RequestHelperService
{
    /** @var RecursiveValidator  */
    private $validator;

    /**
     * RequestHelperService constructor.
     * @param RecursiveValidator $validator
     */
    public function __construct(RecursiveValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @return array
     * @throws \Exception
     */
    public function validate(ParamFetcher $paramFetcher)
    {
        $requestType = $paramFetcher->get('Type');

        if (!$requestType) {
            throw new \Exception('Undefined type request');
        }

        $getDataMethod = 'get' . ucfirst($requestType) . 'Data';
        $getConstraintsMethod = 'get' . ucfirst($requestType) . 'Constraints';

        $data = $this->$getDataMethod($paramFetcher);
        $constraints = $this->$getConstraintsMethod();

        $errors = [];

        foreach ($constraints as $name => $constraint) {
            $value = $data[$name] ?? null;
            $validationResult = $this->validator->validate($value, $constraint);

            if (count($validationResult)) {
                /** @var ConstraintViolation $constraintViolation */
                $constraintViolation = $validationResult[0];
                $errors[$name] = $constraintViolation->getMessage();
            }
        }

        return $errors;
    }

    /**
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    private function getFeedbackData(ParamFetcher $paramFetcher)
    {
        return [
            'Name'  =>  null/*$paramFetcher->get('Name')*/,
            'Phone' =>  null/*$paramFetcher->get('Phone')*/,
            'Agree' =>  $paramFetcher->get('Agree')
        ];
    }

    /**
     * @return array
     */
    private function getFeedbackConstraints()
    {
        return [
            'Name'  =>  [
                new NotBlank(['message' => 'Введите ФИО'])
            ],
            'Phone' =>  [
                new NotBlank(['message' => 'Введите телефон']),
                new Regex(['pattern' => '/^\d{10}$/', 'message' => 'Неверно введен телефон'])
            ],
            'Agree' =>  [
                new IsTrue(['message' => 'Необходимо согласиться с условиями'])
            ]
        ];
    }

}