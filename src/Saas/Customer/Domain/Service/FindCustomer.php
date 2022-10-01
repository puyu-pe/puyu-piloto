<?php

namespace App\Saas\Customer\Domain\Service;

use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use Symfony\Component\Uid\Uuid;

class FindCustomer
{
    public function __construct(
        private readonly CustomerRepository $repository
    ) {
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(string $id): Customer
    {
        $customer = $this->repository->search(Uuid::fromString($id));

        $this->guard($id, $customer);

        return $customer;
    }

    /**
     * @throws \App\Saas\Customer\Domain\Exception\CustomerNotFound
     */
    private function guard(string $id, Customer $customer = null): void
    {
        if (is_null($customer)) {
            throw new CustomerNotFound($id);
        }
    }
}
