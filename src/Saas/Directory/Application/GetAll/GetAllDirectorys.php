<?php

namespace App\Saas\Directory\Application\GetAll;

use App\Saas\Directory\Domain\Entity\Directory;
use App\Saas\Directory\Domain\Repository\DirectoryRepository;

class GetAllDirectorys
{
    public function __construct(
        private readonly DirectoryRepository $directoryRepository,
    ) {
    }

    /**
     * @return Directory[]
     */
    public function __invoke(): array
    {
        return $this->directoryRepository->getAll();
    }
}
