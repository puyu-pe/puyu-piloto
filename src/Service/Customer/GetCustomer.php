<?php

namespace App\Service\Customer;

use App\Model\Exception\Customer\CustomerNotFound;
use App\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Entity\Customer;

class GetCustomer
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
    ) {
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(int $id): Customer
    {
        $customer = $this->customerRepository->find($id);

        if (!$customer) {
            CustomerNotFound::throwException($id);
        }
        return $customer;
    }
}
