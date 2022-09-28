<?php

namespace App\Saas\CustomerContact\Domain\Exception;

class CustomerContactNotFound extends \App\Saas\Shared\Domain\Exception\DomainError
{
    public function __construct(
        private readonly string $id,
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'customer_contact_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf('El contacto del cliente <%s> no fue encontrado', $this->id);
    }
}
