<?php

namespace App\Saas\Product\Domain\Exception;

class ProductNotFound extends \App\Saas\Shared\Domain\Exception\DomainError
{
    public function __construct(
        private readonly string $id,
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'product_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf('El producto <%s> no fue encontrado', $this->id);
    }
}
