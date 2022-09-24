<?php

namespace App\Saas\Product\Domain\Exception;

use App\Saas\Shared\Domain\Exception\DomainError;

class ProductDataException extends DomainError
{
    public function __construct(
        private readonly string $errorCode,
        private readonly string $errorMessage,
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return $this->errorCode;
    }

    public function errorMessage(): string
    {
        return $this->errorMessage;
    }
}
