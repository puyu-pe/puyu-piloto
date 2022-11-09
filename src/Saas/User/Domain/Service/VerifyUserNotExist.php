<?php

namespace App\Saas\User\Domain\Service;

use App\Saas\User\Domain\Exception\UserAlreadyExist;

class VerifyUserNotExist
{
    public function __construct(
        private readonly FindUserByUsername $findUserByUsername,
    ) {
    }

    /**
     * @throws UserAlreadyExist
     */
    public function __invoke(string $username): void
    {
        $user = ($this->findUserByUsername)($username);

        if ($user !== null) {
            throw new UserAlreadyExist($username);
        }
    }
}