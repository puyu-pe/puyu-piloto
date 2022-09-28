<?php

namespace App\Saas\Shared\Infrastructure\Validation;

use App\Saas\Shared\Domain\Validation\ValidationError;
use App\Saas\Shared\Domain\Validation\Validator as DomainValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator implements DomainValidator
{
    public function __construct(
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @return ValidationError[]
     */
    public function validate(object $value): array
    {
        $errors = $this->validator->validate($value);
        if (count($errors)) {
            $errorsArray = [];
            for ($i = 0; $i < count($errors); $i++) {
                $errorObject = new ValidationError(
                    $errors->get($i)->getPropertyPath(),
                    $errors->get($i)->getMessage()
                );

                $errorsArray[] = $errorObject;
            }

            return $errorsArray;
        } else {
            return [];
        }
    }
}
