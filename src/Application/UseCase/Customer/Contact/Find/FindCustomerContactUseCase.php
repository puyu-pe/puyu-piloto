<?php

namespace App\Application\UseCase\Customer\Contact\Find;

use App\Domain\Customer\Contact\FindCustomerContact;
use App\Domain\Entity\CustomerContact;
use App\Domain\Repository\CustomerContactRepository;

class FindCustomerContactUseCase
{
    private FindCustomerContact $finder;

    public function __construct(
        CustomerContactRepository $customerContactRepository,
    ) {
        $this->finder = new FindCustomerContact($customerContactRepository);
    }

    public function __invoke(FindCustomerContactCommand $command): CustomerContact
    {
        return ($this->finder)($command->getId());
    }
}
