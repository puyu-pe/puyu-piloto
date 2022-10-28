<?php

namespace App\Saas\Contact\Domain\Service;

use App\Saas\Contact\Domain\Entity\Contact;
use App\Saas\Contact\Domain\Exception\ContactNotFound;
use App\Saas\Contact\Domain\Repository\ContactRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class FindContact
{
    public function __construct(
        private readonly ContactRepository $repository
    ) {
    }

    /**
     * @throws ContactNotFound
     */
    public function __invoke(string $id): Contact
    {
        $contact = $this->repository->search(Uuid::fromString($id));
        $this->guard($id, $contact);

        return $contact;
    }

    /**
     * @throws ContactNotFound
     */
    private function guard(string $id, Contact $contact = null): void
    {
        if (is_null($contact)) {
            throw new ContactNotFound($id);
        }
    }
}
