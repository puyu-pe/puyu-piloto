<?php

namespace App\Service\Company\Representative;


use App\Model\Exception\Company\CompanyRepresentativeNotFound;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCompanyRepresentative
{
    public function __construct(
        private readonly GetCompanyRepresentative $getCompanyRepresentative,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    /**
     * @throws CompanyRepresentativeNotFound
     */
    public function __invoke(int $id): void
    {
        $companyRepresentative = ($this->getCompanyRepresentative)($id);
        $this->entityManager->remove($companyRepresentative);
        $this->entityManager->flush();
    }
}