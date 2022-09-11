<?php

namespace App\Service\Customer\Contact;

use App\Model\Exception\Customer\CustomerContactNotFound;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCustomerContact
{
    public function __construct(
        private readonly GetCustomerContact $getCustomerContact,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws CustomerContactNotFound
     */
    public function __invoke(int $id): void
    {
        $customerContact = ($this->getCustomerContact)($id);
        $this->entityManager->remove($customerContact);
        $this->entityManager->flush();
    }
}
