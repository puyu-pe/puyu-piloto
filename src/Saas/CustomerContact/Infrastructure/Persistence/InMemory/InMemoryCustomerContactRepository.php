<?php

namespace App\Saas\CustomerContact\Infrastructure\Persistence\InMemory;

use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Repository\CustomerContactRepository;
use Symfony\Component\Uid\Uuid;

class InMemoryCustomerContactRepository implements CustomerContactRepository
{
    /** @var CustomerContact[] */
    protected array $customerContacts = [];

    public function save(CustomerContact $customerContact): void
    {
        $this->customerContacts[$customerContact->getId()->toRfc4122()] = $customerContact;
    }

    public function delete(CustomerContact $customerContact): void
    {
        unset($this->customerContacts[$customerContact->getId()->toRfc4122()]);
    }

    public function search(Uuid $id): ?CustomerContact
    {
        return $this->customerContacts[$id->toRfc4122()] ?? null;
    }

    /**
     * @return CustomerContact[]
     */
    public function getAll(): array
    {
        return $this->customerContacts;
    }
}
