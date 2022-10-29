<?php

namespace App\Saas\Project\Domain\Service;

use App\Saas\Project\Domain\Entity\Project;
use App\Saas\Project\Domain\Exception\ProjectNotFound;
use App\Saas\Project\Domain\Repository\ProjectRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class FindProject
{
    public function __construct(
        private readonly ProjectRepository $repository
    ) {
    }

    /**
     * @throws ProjectNotFound
     */
    public function __invoke(string $id): Project
    {
        $project = $this->repository->search(Uuid::fromString($id));

        $this->guard($id, $project);

        return $project;
    }

    /**
     * @throws \App\Saas\Project\Domain\Exception\ProjectNotFound
     */
    private function guard(string $id, Project $customerContact = null): void
    {
        if (is_null($customerContact)) {
            throw new ProjectNotFound($id);
        }
    }
}
