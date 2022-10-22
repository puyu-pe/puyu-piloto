<?php

namespace App\Saas\Project\Application\Edit;

use App\Saas\Project\Domain\Entity\Project;
use App\Saas\Project\Domain\Exception\ProjectDataException;
use App\Saas\Project\Domain\Exception\ProjectNotFound;
use App\Saas\Project\Domain\Repository\ProjectRepository;
use App\Saas\Project\Domain\Service\FindProject;
use App\Saas\Shared\Domain\Validation\Validator;

class EditProject
{
    private FindProject $finder;

    public function __construct(
        private readonly ProjectRepository $repository,
        private readonly Validator $validator,
    ) {
        $this->finder = new FindProject($repository);
    }

    /**
     * @throws ProjectDataException
     * @throws ProjectNotFound
     */
    public function __invoke(
        string $id,
        EditProjectDto $dto,
    ): Project {
        $this->guard($dto);
        $project = ($this->finder)($id);

        $project
            ->setCustomer($dto->getCustomer())
            ->setProduct($dto->getProduct());

        $this->repository->save($project);

        return $project;
    }

    /**
     * @throws \App\Saas\Project\Domain\Exception\ProjectDataException
     */
    public function guard(EditProjectDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            $error = $errors[0];
            throw new ProjectDataException($error->getField(), $error->getMessage());
        }
    }
}
