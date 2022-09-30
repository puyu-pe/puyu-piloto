<?php

namespace App\Saas\Customer\Application\Edit;

class EditCustomerDto
{
    public function __construct(
        private readonly ?string $document_number = null,
        private readonly ?string $name = null,
        private readonly ?string $address = null,
        private readonly ?string $email = null,
        private readonly ?string $phone = null,
    ) {
    }
    public function getDocument_number(): ?string
    {
        return $this->document_number;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }
}
