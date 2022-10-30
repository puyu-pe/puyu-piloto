<?php

namespace App\Saas\Directory\Domain\Service;

use App\Saas\Directory\Domain\Entity\Directory;
use App\Saas\Directory\Domain\Exception\DirectoryNotFound;
use App\Saas\Directory\Domain\Repository\DirectoryRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class FindDirectory
{
    public function __construct(
        private readonly DirectoryRepository $repository
    ) {
    }

    /**
     * @throws DirectoryNotFound
     */
    public function __invoke(string $id): Directory
    {
        $directory = $this->repository->search(Uuid::fromString($id));

        $this->guard($id, $directory);

        return $directory;
    }

    /**
     * @throws \App\Saas\Directory\Domain\Exception\DirectoryNotFound
     */
    private function guard(string $id, Directory $customerContact = null): void
    {
        if (is_null($customerContact)) {
            throw new DirectoryNotFound($id);
        }
    }
}
