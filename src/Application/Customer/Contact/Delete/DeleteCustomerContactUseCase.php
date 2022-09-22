<?php

namespace App\Application\Customer\Contact\Delete;

use App\Domain\Exception\Customer\Contact\CustomerContactNotFound;
use App\Domain\Repository\CustomerContactRepository;
use App\Domain\Service\Customer\Contact\FindCustomerContact;

class DeleteCustomerContactUseCase
{
    private FindCustomerContact $finder;

    public function __construct(
        private readonly CustomerContactRepository $repository
    ) {
        $this->finder = new FindCustomerContact($repository);
    }

    /**
     * @throws CustomerContactNotFound
     */
    public function __invoke(string $id): void
    {
        $customerContact = ($this->finder)($id);
        $this->repository->delete($customerContact);
    }
}
