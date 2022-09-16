<?php

namespace App\Domain\Customer\Contact;

use App\Application\Exception\Customer\CustomerContactNotFound;
use App\Domain\Entity\CustomerContact;
use App\Domain\Repository\CustomerContactRepository;

class FindCustomerContact
{
    public function __construct(
        private readonly CustomerContactRepository $repository
    )
    {
    }

    public function __invoke(int $id): CustomerContact
    {
        $customerContact = $this->repository->search($id);

        $this->guard($id, $customerContact);

        return $customerContact;
    }

    /**
     * @throws CustomerContactNotFound
     */
    private function guard(int $id, CustomerContact $customerContact = null): void
    {
        if(is_null($customerContact)){
            CustomerContactNotFound::throwException($id);
        }
    }
}