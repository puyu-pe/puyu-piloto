<?php

namespace App\Saas\CustomerContact\Application\Create;

class CreateCustomerContactDto
{
    public function __construct(
        private readonly ?string $name = null,
        private readonly ?string $lastName = null,
        private readonly ?string $phone = null,
        private readonly ?string $jobTitle = null,
    ) {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }
}
