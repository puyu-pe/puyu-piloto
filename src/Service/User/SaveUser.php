<?php

namespace App\Service\User;

use App\Entity\User;
use App\Form\Type\User\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class SaveUser
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory
    ) {
    }

    public function __invoke(Request $request): array
    {
        $customerContact = new User();
        $form = $this->formFactory->create(UserType::class, $customerContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($customerContact);
            $this->entityManager->flush();
            return [$customerContact, null];
        }

        return [null, $form];
    }
}
