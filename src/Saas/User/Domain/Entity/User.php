<?php

namespace App\Saas\User\Domain\Entity;

use Symfony\Component\Uid\Uuid;

class User
{
    public function __construct(
        private readonly Uuid $id,
        private string $username,
        private string $password,
        private string $fullName,
        private int $enabled,
    ) {
    }

    public static function create(
        string $username,
        string $password,
        string $fullName,
        int $enabled,
    ): self {
        return new self(
            Uuid::v4(),
            $username,
            $password,
            $fullName,
            $enabled
        );
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function isEnabled(): ?int
    {
        return $this->enabled;
    }

    public function setEnabled(int $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}
