<?php

namespace App\Saas\Shared\Domain\Validation;

interface Validator
{
    /**
     * @return ValidationError[]
     */
    public function validate(object $value): array;
}
