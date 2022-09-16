<?php

namespace App\Application\UseCase\Customer\Contact\Find;

use App\Domain\Entity\CustomerContact;

class FindCustomerContactCommandHandler
{
    public function __construct(
        private readonly FindCustomerContactUseCase $useCase
    ) {
    }

    public function __invoke(FindCustomerContactCommand $command): CustomerContact
    {
        return ($this->useCase)($command);
    }
}
