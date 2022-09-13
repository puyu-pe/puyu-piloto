<?php

namespace App\Service\Customer\Contact;

use App\Entity\CustomerContact;
use App\Model\Exception\Customer\CustomerContactNotFound;
use App\Repository\CustomerContactRepository;

class GetCustomerContactById
{
    public function __construct(
        private readonly CustomerContactRepository $customerContactRepository,
    ) {
    }

    /**
     * @throws CustomerContactNotFound
     */
    public function __invoke(int $id): CustomerContact
    {
        $customerContact = $this->customerContactRepository->find($id);

        if (!$customerContact) {
            CustomerContactNotFound::throwException();
        }
        return $customerContact;
    }
}
