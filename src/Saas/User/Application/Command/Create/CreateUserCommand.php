<?php

declare(strict_types=1);

namespace App\Saas\User\Application\Command\Create;

use App\Shared\Domain\Bus\Command\Command;

final class CreateUserCommand implements Command
{
    private string $username;
    private string $fullName;
    private string $password;
    private bool $enabled;

    public function __construct(string $username, string $password, string $fullName, bool $enabled)
    {
        $this->username = $username;
        $this->fullName = $fullName;
        $this->password = $password;
        $this->enabled = $enabled;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }
}
