<?php

namespace App\Service\Customer;

use App\Entity\Customer;
use App\Form\Type\Customer\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class SaveCustomer
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory
    ) {
    }

    public function __invoke(Request $request): array
    {
        $customer = new Customer();
        $form = $this->formFactory->create(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            return [$customer, null];
        }

        return [null, $form];
    }
}
