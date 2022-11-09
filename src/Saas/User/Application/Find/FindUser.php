<?php

namespace App\Saas\User\Application\Find;

use App\Saas\User\Domain\Exception\UserNotFound;
use App\Saas\User\Domain\Service\FindUser as DomainFindUser;
use App\Saas\User\Domain\User;
use App\Saas\User\Domain\UserRepository;

class FindUser
{
    private DomainFindUser $finder;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->finder = new DomainFindUser($userRepository);
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(string $id): User
    {
        return ($this->finder)($id);
    }
}
