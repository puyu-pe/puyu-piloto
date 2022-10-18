<?php

namespace App\Saas\User\Domain\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use OpenApi\Attributes as OA;

class User implements UserInterface, PasswordAuthenticatedUserInterface
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

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    #[OA\Property(type:"string[]")]
    public function getRoles(): array
    {
        //$roles = $this->roles;
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        //$this->password = null;
    }
}
