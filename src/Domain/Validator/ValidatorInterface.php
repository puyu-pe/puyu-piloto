<?php

namespace App\Domain\Validator;

interface ValidatorInterface
{
    public function validate(object $value): \Countable;
}