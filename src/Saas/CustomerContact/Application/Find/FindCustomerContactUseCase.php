<?php

namespace App\Saas\CustomerContact\Application\Find;

use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Exception\ProductNotFound;
use App\Saas\CustomerContact\Domain\Repository\CustomerContactRepository;
use App\Saas\CustomerContact\Domain\Service\FindCustomerContact;

class FindCustomerContactUseCase
{
    private FindCustomerContact $finder;

    public function __construct(
        CustomerContactRepository $customerContactRepository,
    ) {
        $this->finder = new FindCustomerContact($customerContactRepository);
    }

    /**
     * @throws ProductNotFound
     */
    public function __invoke(string $id): CustomerContact
    {
        return ($this->finder)($id);
    }
}
