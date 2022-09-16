<?php

namespace App\Application\UseCase\Customer\Contact\Get;

use App\Domain\Repository\CustomerContactRepository;

class GetCustomerContacts
{
    public function __construct(
        private readonly CustomerContactRepository $customerContactRepository,
    ) {
    }

    public function __invoke(): array
    {
        return $this->customerContactRepository->findAll();
    }
}