<?php

namespace App\Saas\Directory\Domain\Repository;

use App\Saas\Directory\Domain\Entity\Directory;
use App\Shared\Domain\ValueObjects\Uuid;

/**
 * @ent Traversable<\Vendor\ItemInterface>
 */
interface DirectoryRepository
{
    public function save(Directory $directory): void;

    public function delete(Directory $directory): void;

    public function search(Uuid $id): ?Directory;

    /**
     * @return Directory[]
     */
    public function getAll(): array;
}
