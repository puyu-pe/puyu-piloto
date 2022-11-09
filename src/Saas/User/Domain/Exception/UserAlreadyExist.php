<?php

namespace App\Saas\User\Domain\Exception;

use App\Shared\Domain\DomainError;

final class UserAlreadyExist extends DomainError
{
    private string $username;

    public function __construct(string $username)
    {
        $this->username = $username;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'user_already_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The user <%s> already exist', $this->username);
    }
}
