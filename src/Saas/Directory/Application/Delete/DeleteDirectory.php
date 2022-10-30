<?php

namespace App\Saas\Directory\Application\Delete;

use App\Saas\Directory\Domain\Exception\DirectoryNotFound;
use App\Saas\Directory\Domain\Repository\DirectoryRepository;
use App\Saas\Directory\Domain\Service\FindDirectory;

class DeleteDirectory
{
    private FindDirectory $finder;

    public function __construct(
        private readonly DirectoryRepository $repository
    ) {
        $this->finder = new FindDirectory($repository);
    }

    /**
     * @throws DirectoryNotFound
     */
    public function __invoke(string $id): void
    {
        $directory = ($this->finder)($id);
        $this->repository->delete($directory);
    }
}
