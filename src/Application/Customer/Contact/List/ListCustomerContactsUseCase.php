<?php

namespace App\Application\Customer\Contact\List;

use App\Domain\Entity\CustomerContact;
use App\Domain\Repository\CustomerContactRepository;

class ListCustomerContactsUseCase
{
    public function __construct(
        private readonly CustomerContactRepository $customerContactRepository,
    ) {
    }

    /**
     * @return CustomerContact[]
     */
    public function __invoke(): array
    {
        return $this->customerContactRepository->getAll();
    }
}
