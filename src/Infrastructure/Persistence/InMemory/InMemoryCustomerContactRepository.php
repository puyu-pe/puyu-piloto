<?php

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Entity\CustomerContact;
use App\Domain\Repository\CustomerContactRepository;
use Symfony\Component\Uid\Uuid;

class InMemoryCustomerContactRepository
{
    /** @var CustomerContact[] */
    protected array $customerContacts = [];

    public function save(CustomerContact $customerContact): void
    {
        $this->customerContacts[$customerContact->getId()->toRfc4122()] = $customerContact;
    }

    public function delete(CustomerContact $customerContact): void
    {
        // TODO: Implement delete() method.
    }

    public function search(Uuid $id): ?CustomerContact
    {
        return null;
    }

    /**
     * @return CustomerContact[]
     */
    public function getAll(): array
    {
        return [];
    }
}
