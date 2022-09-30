<?php

namespace App\Saas\Customer\Application\Delete;

use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Service\FindCustomer;

class DeleteCustomerUseCase
{
    private FindCustomer $finder;

    public function __construct(
        private readonly CustomerRepository $repository
    ) {
        $this->finder = new FindCustomer($repository);
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(string $id): void
    {
        $customer = ($this->finder)($id);
        $this->repository->delete($customer);
    }
}
