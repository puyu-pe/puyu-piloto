<?php

namespace App\Saas\User\Domain\Service;

use App\Saas\User\Domain\Entity\User;
use App\Saas\User\Domain\Exception\UserNotFound;
use App\Saas\User\Domain\Repository\UserRepository;
use Symfony\Component\Uid\Uuid;

class FindUser
{
    public function __construct(
        private readonly UserRepository $repository
    ) {
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(string $id): User
    {
        $user = $this->repository->search(Uuid::fromString($id));

        $this->guard($id, $user);

        return $user;
    }

    /**
     * @throws \App\Saas\User\Domain\Exception\UserNotFound
     */
    private function guard(string $id, User $user = null): void
    {
        if (is_null($user)) {
            throw new UserNotFound($id);
        }
    }
}
