<?php

namespace App\Saas\Customer\Domain\Repository;

use App\Saas\Customer\Domain\Customer;
use App\Shared\Domain\ValueObjects\Uuid;

/**
 * @ent Traversable<\Vendor\ItemInterface>
 */
interface CustomerRepository
{
    public function save(Customer $customer): void;

    public function delete(Customer $customer): void;

    public function search(Uuid $id): ?Customer;

    /**
     * @return \App\Saas\Customer\Domain\Customer[]
     */
    public function getAll(): array;
}
