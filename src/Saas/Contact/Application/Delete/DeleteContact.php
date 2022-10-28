<?php

namespace App\Saas\Contact\Application\Delete;

use App\Saas\Contact\Domain\Exception\ContactNotFound;
use App\Saas\Contact\Domain\Repository\ContactRepository;
use App\Saas\Contact\Domain\Service\FindContact;

class DeleteContact
{
    private FindContact $finder;

    public function __construct(
        private readonly ContactRepository $repository
    ) {
        $this->finder = new FindContact($repository);
    }

    /**
     * @throws ContactNotFound
     */
    public function __invoke(string $id): void
    {
        $contact = ($this->finder)($id);
        $this->repository->delete($contact);
    }
}
