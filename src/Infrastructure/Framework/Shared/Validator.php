<?php

namespace App\Infrastructure\Framework\Shared;

use App\Domain\Validator\ValidatorInterface as ValidatorInterfaceApp;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator implements ValidatorInterfaceApp
{
    public function __construct(
        private readonly ValidatorInterface $validator
    )
    {
    }

    public function validate(object $value) : \Countable
    {
        return $this->validator->validate($value);
    }
}