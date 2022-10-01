<?php

namespace App\Saas\Shared\Domain\Exception;

use Exception;

abstract class DomainError extends Exception
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    abstract public function errorCode(): string;

    abstract public function errorMessage(): string;
}
