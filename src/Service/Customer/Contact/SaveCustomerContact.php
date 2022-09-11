<?php

namespace App\Service\Customer\Contact;

use App\Entity\CustomerContact;
use App\Form\Type\Customer\CustomerContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class SaveCustomerContact
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory
    ) {
    }

    public function __invoke(Request $request): array
    {
        $customerContact = new CustomerContact();
        $form = $this->formFactory->create(CustomerContactType::class, $customerContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($customerContact);
            $this->entityManager->flush();
            return [$customerContact, null];
        }

        return [null, $form];
    }
}
