<?php

namespace App\Saas\User\Application\Create;

class CreateUserDto
{
    public function __construct(
        private readonly ?string $username = null,
        private readonly ?string $password = null,
        private readonly ?string $fullName = null,
        private readonly ?string $status = null,
    ) {
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function isEnabled(): ?int
    {
        return $this->enabled;
    }

}
