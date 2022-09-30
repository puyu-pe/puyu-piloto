<?php

namespace App\Saas\Customer\Application\Find;

use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Service\FindCustomer;

class FindCustomerUseCase
{
    private FindCustomer $finder;

    public function __construct(
        CustomerRepository $customerRepository,
    ) {
        $this->finder = new FindCustomer($customerRepository);
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(string $id): Customer
    {
        return ($this->finder)($id);
    }
}
