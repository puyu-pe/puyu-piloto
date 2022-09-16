<?php

namespace App\Application\UseCase\Customer\Contact\Find;

class FindCustomerContactCommand
{
    public function __construct(
        private readonly ?int $id = null,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
