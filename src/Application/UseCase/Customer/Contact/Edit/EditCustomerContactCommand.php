<?php

namespace App\Application\UseCase\Customer\Contact\Edit;

class EditCustomerContactCommand
{
    public function __construct(
        private readonly ?string $id = null,
        private readonly ?string $name = null,
        private readonly ?string $lastName = null,
        private readonly ?string $phone = null,
        private readonly ?string $jobTitle = null,
    )
    {
    }

    public function getId(): ?string
    {
        return $this->id;
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