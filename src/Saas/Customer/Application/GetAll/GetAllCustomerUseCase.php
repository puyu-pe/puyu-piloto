<?php

namespace App\Saas\Customer\Application\GetAll;

use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Customer\Domain\Repository\CustomerRepository;

class GetAllCustomerUseCase
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
