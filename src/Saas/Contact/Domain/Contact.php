<?php

namespace App\Saas\Contact\Domain;

use App\Shared\Domain\Traits\SoftDeleteable;
use App\Shared\Domain\Traits\Timestampable;
use App\Shared\Domain\ValueObjects\Uuid;

class Contact
{
    use Timestampable;
    use SoftDeleteable;

    public function __construct(
        private readonly Uuid $id,
        private string $name,
        private string $lastName,
        private ?string $phone,
        private ?string $jobTitle,
    ) {
    }

    public static function create(
        string $name,
        string $lastName,
        string $phone,
        string $jobTitle,
    ): self {
        return new self(
            Uuid::v4(),
            $name,
            $lastName,
            $phone,
            $jobTitle,
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(
        string $name
    ): self {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(
        string $lastName
    ): self {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }
}
