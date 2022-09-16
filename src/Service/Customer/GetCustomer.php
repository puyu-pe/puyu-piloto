<?php

namespace App\Service\Customer;

use App\Entity\Customer;
use App\Model\Exception\Customer\CustomerNotFound;
use App\Repository\CustomerRepository;

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
            CustomerNotFound::throwException();
        }
        return $customer;
    }}