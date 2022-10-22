<?php

namespace App\Saas\Project\Application\Find;

use App\Saas\Project\Domain\Entity\Project;
use App\Saas\Project\Domain\Exception\ProjectNotFound;
use App\Saas\Project\Domain\Repository\ProjectRepository;
use App\Saas\Project\Domain\Service\FindProject as DomainFindProject;

class FindProject
{
    private DomainFindProject $finder;

    public function __construct(
        ProjectRepository $projectRepository,
    ) {
        $this->finder = new DomainFindProject($projectRepository);
    }

    /**
     * @throws ProjectNotFound
     */
    public function __invoke(string $id): Project
    {
        return ($this->finder)($id);
    }
}
