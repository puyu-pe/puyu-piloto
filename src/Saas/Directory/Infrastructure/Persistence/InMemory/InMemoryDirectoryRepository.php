<?php

namespace App\Saas\Directory\Infrastructure\Persistence\InMemory;

use App\Saas\Directory\Domain\Entity\Directory;
use App\Saas\Directory\Domain\Repository\DirectoryRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class InMemoryDirectoryRepository implements DirectoryRepository
{
    /** @var Directory[] */
    protected array $directorys = [];

    public function save(Directory $directory): void
    {
        $this->directorys[$directory->getId()->toRfc4122()] = $directory;
    }

    public function delete(Directory $directory): void
    {
        unset($this->directorys[$directory->getId()->toRfc4122()]);
    }

    public function search(Uuid $id): ?Directory
    {
        return $this->directorys[$id->toRfc4122()] ?? null;
    }

    /**
     * @return Directory[]
     */
    public function getAll(): array
    {
        return $this->directorys;
    }
}
