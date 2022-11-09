<?php

namespace App\Saas\User\Application\Delete;

use App\Saas\User\Domain\Exception\UserNotFound;
use App\Saas\User\Domain\Service\FindUser as DomainFindUser;
use App\Saas\User\Domain\UserRepository;

;

class DeleteUser
{
    private DomainFindUser $finder;

    public function __construct(
        private readonly UserRepository $repository
    ) {
        $this->finder = new DomainFindUser($repository);
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
