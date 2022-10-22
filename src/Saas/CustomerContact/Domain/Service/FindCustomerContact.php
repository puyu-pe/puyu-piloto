<?php

namespace App\Saas\CustomerContact\Domain\Service;

use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Exception\CustomerContactNotFound;
use App\Saas\CustomerContact\Domain\Repository\CustomerContactRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class FindCustomerContact
{
    public function __construct(
        private readonly CustomerContactRepository $repository
    ) {
    }

    /**
     * @throws CustomerContactNotFound
     */
    public function __invoke(string $id): CustomerContact
    {
        $customerContact = $this->repository->search(Uuid::fromString($id));
        $this->guard($id, $customerContact);

        return $customerContact;
    }

    /**
     * @throws CustomerContactNotFound
     */
    private function guard(string $id, CustomerContact $customerContact = null): void
    {
        if (is_null($customerContact)) {
            throw new CustomerContactNotFound($id);
        }
    }
}
