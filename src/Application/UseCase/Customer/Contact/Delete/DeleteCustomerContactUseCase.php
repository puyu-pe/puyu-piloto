<?php

namespace App\Application\UseCase\Customer\Contact\Delete;

use App\Domain\Customer\Contact\FindCustomerContact;
use App\Domain\Repository\CustomerContactRepository;

class DeleteCustomerContactUseCase
{
    private FindCustomerContact $finder;

    public function __construct(
        private readonly CustomerContactRepository $repository
    ) {
        $this->finder = new FindCustomerContact($repository);
    }

    public function __invoke(DeleteCustomerContactCommand $command): void
    {
        $customerContact = ($this->finder)($command->getId());
        $this->repository->delete($customerContact);
    }
}
