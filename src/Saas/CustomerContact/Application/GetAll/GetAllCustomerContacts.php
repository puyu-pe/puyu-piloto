<?php

namespace App\Saas\CustomerContact\Application\GetAll;

use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Repository\CustomerContactRepository;

class GetAllCustomerContactsUseCase
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
