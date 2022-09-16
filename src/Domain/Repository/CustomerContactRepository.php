<?php

namespace App\Domain\Repository;

use App\Domain\Entity\CustomerContact;

interface CustomerContactRepository
{
    public function save(CustomerContact $customerContact): void;

    public function delete(CustomerContact $customerContact): void;

    public function search(int $id): ?CustomerContact;
}
