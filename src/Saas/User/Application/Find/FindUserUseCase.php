<?php

namespace App\Saas\User\Application\Find;

use App\Saas\User\Domain\Entity\User;
use App\Saas\User\Domain\Exception\UserNotFound;
use App\Saas\User\Domain\Repository\UserRepository;
use App\Saas\User\Domain\Service\FindUser;

class FindUserUseCase
{
    private FindUser $finder;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->finder = new FindUser($userRepository);
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(string $id): User
    {
        return ($this->finder)($id);
    }
}
