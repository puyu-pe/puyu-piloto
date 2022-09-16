<?php

namespace App\Application\UseCase\Customer\Contact\Delete;

class DeleteCustomerContactCommandHandler
{

    public function __construct(
        private readonly DeleteCustomerContactUseCase $useCase
    ) {
    }

    public function __invoke(DeleteCustomerContactCommand $command): void
    {
        ($this->useCase)($command);
    }
}