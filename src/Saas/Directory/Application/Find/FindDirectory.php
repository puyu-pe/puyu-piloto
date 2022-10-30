<?php

namespace App\Saas\Directory\Application\Find;

use App\Saas\Directory\Domain\Entity\Directory;
use App\Saas\Directory\Domain\Exception\DirectoryNotFound;
use App\Saas\Directory\Domain\Repository\DirectoryRepository;
use App\Saas\Directory\Domain\Service\FindDirectory as DomainFindDirectory;

class FindDirectory
{
    private DomainFindDirectory $finder;

    public function __construct(
        DirectoryRepository $directoryRepository,
    ) {
        $this->finder = new DomainFindDirectory($directoryRepository);
    }

    /**
     * @throws DirectoryNotFound
     */
    public function __invoke(string $id): Directory
    {
        return ($this->finder)($id);
    }
}
