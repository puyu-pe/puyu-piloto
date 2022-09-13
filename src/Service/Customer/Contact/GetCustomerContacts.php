<?php

namespace App\Service\Customer\Contact;

use App\Repository\CustomerContactRepository;

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