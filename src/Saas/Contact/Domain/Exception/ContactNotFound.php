<?php

namespace App\Saas\Contact\Domain\Exception;

use App\Saas\Shared\Domain\Exception\DomainError;

class ContactNotFound extends DomainError
{
    public function __construct(
        private readonly string $id,
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'contact_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf('El contacto del cliente <%s> no fue encontrado', $this->id);
    }
}
