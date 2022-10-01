<?php

namespace App\Saas\Customer\Domain\Exception;

class CustomerNotFound extends \App\Saas\Shared\Domain\Exception\DomainError
{
    public function __construct(
        private readonly string $id,
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'customer_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf('El cliente <%s> no fue encontrado', $this->id);
    }
}
