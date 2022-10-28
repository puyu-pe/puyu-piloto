<?php

namespace App\Saas\Contact\Domain\Repository;

use App\Saas\Contact\Domain\Entity\Contact;
use App\Shared\Domain\ValueObjects\Uuid;

/**
 * @ent Traversable<\Vendor\ItemInterface>
 */
interface ContactRepository
{
    public function save(Contact $contact): void;

    public function delete(Contact $contact): void;

    public function search(Uuid $id): ?Contact;

    /**
     * @return Contact[]
     */
    public function getAll(): array;
}
