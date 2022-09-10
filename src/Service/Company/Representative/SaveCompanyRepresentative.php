<?php

namespace App\Service\Company\Representative;

use App\Entity\CompanyRepresentative;
use App\Form\Type\CompanyRepresentativeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class SaveCompanyRepresentative
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface   $formFactory
    )
    {
    }

    public function __invoke(Request $request): array
    {
        $companyRepresentative = new CompanyRepresentative();
        $form = $this->formFactory->create(CompanyRepresentativeType::class, $companyRepresentative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($companyRepresentative);
            $this->entityManager->flush();
            return [$companyRepresentative, null];
        }

        return [null, $form];
    }
}