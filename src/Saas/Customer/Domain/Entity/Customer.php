<?php

namespace App\Saas\Customer\Domain\Entity;

use Symfony\Component\Uid\Uuid;

class Customer
{
    public function __construct(
        private readonly Uuid $id,
        private string $document_number,
        private string $name,
        private string $address,
        private string $email,
        private string $phone,
    ) {
    }
    public static function create(
        string $document_number,
        string $name,
        string $address,
        string $email,
        string $phone,
    ): self {
        return new self(
            Uuid::v4(),
            $document_number,
            $name,
            $address,
            $email,
            $phone,
        );
    }


    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDocument_number(): ?string
    {
        return $this->document_number;
    }

    public function setDocument_number(string $document_number): self
    {
        $this->document_number = $document_number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
