<?php

namespace App\Saas\Directory\Application\Edit;

class EditDirectoryDto
{
    public function __construct(
        private readonly ?string $customerId = null,
        private readonly ?string $contactId = null,
    ) {
    }

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function getContactId(): ?string
    {
        return $this->contactId;
    }
}
