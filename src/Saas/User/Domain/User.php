<?php

namespace App\Saas\User\Domain;

use App\Shared\Domain\Traits\SoftDeleteable;
use App\Shared\Domain\Traits\Timestampable;
use App\Shared\Domain\ValueObjects\Uuid;

class User
{
    use Timestampable;
    use SoftDeleteable;

    public function __construct(
        private readonly Uuid $id,
        private string $username,
        private string $password,
        private string $fullName,
        private bool $enabled,
    ) {
    }

    public static function create(
        Uuid $id,
        string $username,
        string $password,
        string $fullName,
        bool $enabled,
    ): self {
        return new self(
            $id,
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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        //$roles = $this->roles;
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);
    }
}
