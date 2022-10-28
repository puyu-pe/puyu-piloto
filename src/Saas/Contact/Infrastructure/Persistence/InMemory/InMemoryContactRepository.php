<?php

namespace App\Saas\Contact\Infrastructure\Persistence\InMemory;

use App\Saas\Contact\Domain\Entity\Contact;
use App\Saas\Contact\Domain\Repository\ContactRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class InMemoryContactRepository implements ContactRepository
{
    /** @var Contact[] */
    protected array $contacts = [];

    public function save(Contact $contact): void
    {
        $this->contacts[$contact->getId()->toRfc4122()] = $contact;
    }

    public function delete(Contact $contact): void
    {
        unset($this->contacts[$contact->getId()->toRfc4122()]);
    }

    public function search(Uuid $id): ?Contact
    {
        return $this->contacts[$id->toRfc4122()] ?? null;
    }

    /**
     * @return Contact[]
     */
    public function getAll(): array
    {
        return $this->contacts;
    }
}
