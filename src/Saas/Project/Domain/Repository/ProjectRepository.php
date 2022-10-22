<?php

namespace App\Saas\Project\Domain\Repository;

use App\Saas\Project\Domain\Entity\Project;
use Symfony\Component\Uid\Uuid;

/**
 * @ent Traversable<\Vendor\ItemInterface>
 */
interface ProjectRepository
{
    public function save(Project $project): void;

    public function delete(Project $project): void;

    public function search(Uuid $id): ?Project;

    /**
     * @return Project[]
     */
    public function getAll(): array;
}
