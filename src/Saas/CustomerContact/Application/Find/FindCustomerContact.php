<?php

namespace App\Saas\CustomerContact\Application\Find;

use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Exception\CustomerContactNotFound;
use App\Saas\CustomerContact\Domain\Repository\CustomerContactRepository;
use App\Saas\CustomerContact\Domain\Service\FindCustomerContact as DomainFindCustomerContact;

class FindCustomerContact
{
    private DomainFindCustomerContact $finder;

    public function __construct(
        CustomerContactRepository $customerContactRepository,
    ) {
        $this->finder = new DomainFindCustomerContact($customerContactRepository);
    }

    /**
     * @throws CustomerContactNotFound
     */
    public function __invoke(string $id): CustomerContact
    {
        return ($this->finder)($id);
    }
}