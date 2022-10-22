<?php

namespace App\Saas\Customer\Infrastructure\Persistence\InMemory;

use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class InMemoryCustomerRepository implements CustomerRepository
{
    /** @var Customer[] */
    protected array $customer = [];

    public function save(Customer $customer): void
    {
        $this->customer[$customer->getId()->toRfc4122()] = $customer;
    }

    public function delete(Customer $customer): void
    {
        unset($this->customer[$customer->getId()->toRfc4122()]);
    }

    public function search(Uuid $id): ?Customer
    {
        return $this->customer[$id->toRfc4122()] ?? null;
    }

    /**
     * @return Customer[]
     */
    public function getAll(): array
    {
        return $this->customer;
    }
}
