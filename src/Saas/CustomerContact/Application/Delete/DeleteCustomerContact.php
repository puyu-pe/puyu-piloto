<?php

namespace App\Saas\CustomerContact\Application\Delete;

use App\Saas\CustomerContact\Domain\Exception\CustomerContactNotFound;
use App\Saas\CustomerContact\Domain\Repository\CustomerContactRepository;
use App\Saas\CustomerContact\Domain\Service\FindCustomerContact;

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
