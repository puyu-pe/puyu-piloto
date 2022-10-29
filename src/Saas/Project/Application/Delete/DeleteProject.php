<?php

namespace App\Saas\Project\Application\Delete;

use App\Saas\Project\Domain\Exception\ProjectNotFound;
use App\Saas\Project\Domain\Repository\ProjectRepository;
use App\Saas\Project\Domain\Service\FindProject;

class DeleteProject
{
    private FindProject $finder;

    public function __construct(
        private readonly ProjectRepository $repository
    ) {
        $this->finder = new FindProject($repository);
    }

    /**
     * @throws ProjectNotFound
     */
    public function __invoke(string $id): void
    {
        $project = ($this->finder)($id);
        $this->repository->delete($project);
    }
}
