<?php

namespace App\Saas\User\Application\Delete;

use App\Saas\User\Domain\Exception\UserNotFound;
use App\Saas\User\Domain\Repository\UserRepository;
use App\Saas\User\Domain\Service\FindUser;

class DeleteUser
{
    private FindUser $finder;

    public function __construct(
        private readonly UserRepository $repository
    ) {
        $this->finder = new FindUser($repository);
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(string $id): void
    {
        $user = ($this->finder)($id);
        $this->repository->delete($user);
    }
}
