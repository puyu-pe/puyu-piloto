<?php

namespace App\Domain\Service\Customer\Contact;

use App\Domain\Entity\CustomerContact;
use App\Domain\Exception\Customer\Contact\CustomerContactNotFound;
use App\Domain\Repository\CustomerContactRepository;
use Symfony\Component\Uid\Uuid;

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
