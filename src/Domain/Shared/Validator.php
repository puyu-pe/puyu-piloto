<?php

namespace App\Domain\Shared;

interface Validator
{
    /**
     * @return ValidationError[]
     */
    public function validate(object $value): array;
}
