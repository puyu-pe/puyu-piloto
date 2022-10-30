<?php

namespace App\Saas\Contact\Application\GetAll;

use App\Saas\Contact\Domain\Entity\Contact;
use App\Saas\Contact\Domain\Repository\ContactRepository;

class GetAllContacts
{
    public function __construct(
        private readonly ContactRepository $contactRepository,
    ) {
    }

    /**
     * @return Contact[]
     */
    public function __invoke(): array
    {
        return $this->contactRepository->getAll();
    }
}
