<?php

namespace App\Saas\Project\Application\GetAll;

use App\Saas\Project\Domain\Project;
use App\Saas\Project\Domain\Repository\ProjectRepository;

class GetAllProjects
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    /**
     * @return Project[]
     */
    public function __invoke(): array
    {
        return $this->projectRepository->getAll();
    }
}
