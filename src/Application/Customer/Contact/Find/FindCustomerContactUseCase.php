<?php

namespace App\Application\Customer\Contact\Find;

use App\Domain\Entity\CustomerContact;
use App\Domain\Exception\Customer\Contact\CustomerContactNotFound;
use App\Domain\Repository\CustomerContactRepository;
use App\Domain\Service\Customer\Contact\FindCustomerContact;

class FindCustomerContactUseCase
{
    private FindCustomerContact $finder;

    public function __construct(
        CustomerContactRepository $customerContactRepository,
    ) {
        $this->finder = new FindCustomerContact($customerContactRepository);
    }

    /**
     * @throws CustomerContactNotFound
     */
    public function __invoke(string $id): CustomerContact
    {
        return ($this->finder)($id);
    }
}
