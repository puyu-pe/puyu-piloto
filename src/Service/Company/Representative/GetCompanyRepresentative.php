<?php

namespace App\Service\Company\Representative;

use App\Entity\CompanyRepresentative;
use App\Model\Exception\Company\CompanyRepresentativeNotFound;
use App\Repository\CompanyRepresentativeRepository;

class GetCompanyRepresentative
{
    public function __construct(
        private readonly CompanyRepresentativeRepository $companyRepresentativeRepository,
    )
    {
    }

    /**
     * @throws CompanyRepresentativeNotFound
     */
    public function __invoke(int $id): CompanyRepresentative
    {
        $companyRepresentative = $this->companyRepresentativeRepository->find($id);

        if (!$companyRepresentative) {
            companyRepresentativeNotFound::throwException();
        }
        return $companyRepresentative;
    }
}