<?php

namespace App\Domain\Repository;

use App\Domain\Entity\CustomerContact;
use Symfony\Component\Uid\Uuid;

/**
 * @ent Traversable<\Vendor\ItemInterface>
 */
interface CustomerContactRepository
{
    public function save(CustomerContact $customerContact): void;

    public function delete(CustomerContact $customerContact): void;

    public function search(Uuid $id): ?CustomerContact;

    /**
     * @return CustomerContact[]
     */
    public function getAll(): array;
}
