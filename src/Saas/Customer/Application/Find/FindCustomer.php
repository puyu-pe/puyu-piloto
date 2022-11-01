<?php

namespace App\Saas\Customer\Application\Find;

use App\Saas\Customer\Domain\Customer;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Service\FindCustomer as DomainFindCustomer;

class FindCustomer
{
    private DomainFindCustomer $finder;

    public function __construct(
        CustomerRepository $customerRepository,
    ) {
        $this->finder = new DomainFindCustomer($customerRepository);
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(string $id): Customer
    {
        return ($this->finder)($id);
    }
}
