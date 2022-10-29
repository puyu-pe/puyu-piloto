<?php

namespace App\Saas\Project\Infrastructure\Persistence\InMemory;

use App\Saas\Project\Domain\Entity\Project;
use App\Saas\Project\Domain\Repository\ProjectRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class InMemoryProjectRepository implements ProjectRepository
{
    /** @var Project[] */
    protected array $projects = [];

    public function save(Project $project): void
    {
        $this->projects[$project->getId()->toRfc4122()] = $project;
    }

    public function delete(Project $project): void
    {
        unset($this->projects[$project->getId()->toRfc4122()]);
    }

    public function search(Uuid $id): ?Project
    {
        return $this->projects[$id->toRfc4122()] ?? null;
    }

    /**
     * @return Project[]
     */
    public function getAll(): array
    {
        return $this->projects;
    }
}
