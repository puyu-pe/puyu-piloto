<?php

namespace App\Saas\User\Domain\Exception;

class UserNotFound extends \App\Saas\Shared\Domain\Exception\DomainError
{
    public function __construct(
        private readonly string $id,
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'user_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf('El usuario <%s> no fue encontrado', $this->id);
    }
}
