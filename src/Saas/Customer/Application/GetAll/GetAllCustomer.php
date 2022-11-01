<?php

namespace App\Saas\Customer\Application\GetAll;

use App\Saas\Customer\Domain\Customer;
use App\Saas\Customer\Domain\Repository\CustomerRepository;

class GetAllCustomer
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
    ) {
    }

    /**
     * @return Customer[]
     */
    public function __invoke(): array
    {
        return $this->customerRepository->getAll();
    }
}
