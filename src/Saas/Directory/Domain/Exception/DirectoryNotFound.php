<?php

namespace App\Saas\Directory\Domain\Exception;

class DirectoryNotFound extends \App\Saas\Shared\Domain\Exception\DomainError
{
    public function __construct(
        private readonly string $id,
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'directory_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf('El registro de directorio <%s> no fue encontrado', $this->id);
    }
}
