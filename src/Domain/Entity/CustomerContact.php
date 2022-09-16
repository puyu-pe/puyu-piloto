<?php

namespace App\Domain\Entity;

class CustomerContact
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?string $lastName = null,
        private ?string $phone = null,
        private ?string $jobTitle = null,
    ) {
    }

    public static function create(
        string $name,
        string $lastName,
        string $phone,
        string $jobTitle,
    ): self {
        return new self(
            null,
            $name,
            $lastName,
            $phone,
            $jobTitle,
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(
        string $name
    ): self {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
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

    public function setPhone(
        ?string $phone
    ): self {
        $this->phone = $phone;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(
        ?string $jobTitle
    ): self {
        $this->jobTitle = $jobTitle;

        return $this;
    }
}
