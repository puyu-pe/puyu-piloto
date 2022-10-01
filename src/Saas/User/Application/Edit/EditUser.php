<?php

namespace App\Saas\User\Application\Edit;

use App\Saas\Shared\Domain\Validation\Validator;
use App\Saas\User\Domain\Entity\User;
use App\Saas\User\Domain\Exception\UserDataException;
use App\Saas\User\Domain\Exception\UserNotFound;
use App\Saas\User\Domain\Repository\UserRepository;
use App\Saas\User\Domain\Service\FindUser;

class EditUser
{
    private FindUser $finder;

    public function __construct(
        private readonly UserRepository $repository,
        private readonly Validator $validator,
    ) {
        $this->finder = new FindUser($repository);
    }

    /**
     * @throws UserDataException
     * @throws UserNotFound
     */
    public function __invoke(
        string $id,
        EditUserDto $dto,
    ): User {
        $this->guard($dto);
        $user = ($this->finder)($id);

        $user
            ->setUsername($dto->getUsername())
            ->setPassword($dto->getPassword())
            ->setFullName($dto->getFullName())
            ->setEnabled($dto->getEnabled());

        $this->repository->save($user);

        return $user;
    }

    /**
     * @throws \App\Saas\User\Domain\Exception\UserDataException
     */
    public function guard(EditUserDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            $error = $errors[0];
            throw new UserDataException($error->getField(), $error->getMessage());
        }
    }
}
