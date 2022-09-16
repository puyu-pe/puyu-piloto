<?php

namespace App\Application\UseCase\Customer\Contact\Edit;

class EditCustomerContactCommandHandler
{
    public function __construct(
        private readonly EditCustomerContactUseCase $useCase
    ) {
    }

    public function __invoke(EditCustomerContactCommand $command): CustomerContact
    {
        return ($this->useCase)($command);
    }
}