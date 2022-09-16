<?php

namespace App\Application\UseCase\Customer\Contact\Delete;

class DeleteCustomerContactCommand
{
    public function __construct(
        private readonly ?int $id = null,
    )
    {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}