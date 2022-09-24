<?php

namespace App\Service\Customer;

use App\Model\Exception\Customer\CustomerNotFound;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCustomer
{
    public function __construct(
        private readonly GetCustomer $getCustomer,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(int $id): void
    {
        $getCustomer = new GetCustomer();
        $customer = ($this->getCustomer)($id);
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}
