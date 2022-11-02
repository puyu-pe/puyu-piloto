<?php

namespace App\Saas\Contact\Application\Find;

use App\Saas\Contact\Domain\Contact;
use App\Saas\Contact\Domain\Exception\ContactNotFound;
use App\Saas\Contact\Domain\Repository\ContactRepository;
use App\Saas\Contact\Domain\Service\FindContact as DomainFindContact;

class FindContact
{
    private DomainFindContact $finder;

    public function __construct(
        ContactRepository $contactRepository,
    ) {
        $this->finder = new DomainFindContact($contactRepository);
    }

    /**
     * @throws ContactNotFound
     */
    public function __invoke(string $id): Contact
    {
        return ($this->finder)($id);
    }
}
