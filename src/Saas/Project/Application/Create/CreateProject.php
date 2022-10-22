<?php

namespace App\Saas\Project\Application\Create;

use App\Saas\Project\Domain\Entity\Project;
use App\Saas\Project\Domain\Exception\ProjectDataException;
use App\Saas\Project\Domain\Repository\ProjectRepository;
use App\Saas\Shared\Domain\Validation\Validator;

class CreateProject
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly Validator $validator,
    ) {
    }

    /**
     * @throws ProjectDataException
     */
    public function __invoke(
        CreateProjectDto $dto
    ): Project {
        $this->guard($dto);

        $project = Project::create(
            $dto->getCustomer(),
            $dto->getProduct(),
        );

        $this->projectRepository->save($project);
        return $project;
    }

    /**
     * @throws ProjectDataException
     */
    public function guard(CreateProjectDto $project): void
    {
        $errors = $this->validator->validate($project);
        if (count($errors)) {
            $error = $errors[0];
            throw new ProjectDataException($error->getField(), $error->getMessage());
        }
    }
}
