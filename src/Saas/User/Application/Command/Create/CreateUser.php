<?php

declare(strict_types=1);

namespace App\Saas\User\Application\Command\Create;

use App\Saas\User\Domain\Security\GeneratePassword;
use App\Saas\User\Domain\User;
use App\Saas\User\Domain\Service\VerifyUserNotExist;
use App\Saas\User\Domain\UserRepository;

final class CreateUser
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly VerifyUserNotExist $verifyUserNotExist,
        private readonly GeneratePassword $generatePassword,
    ) {
    }

    public function __invoke(string $username, string $password, string $fullName, bool $enabled): User
    {
        $this->ensureUserExists($username);

        $user = User::create(
            $username,
            $fullName,
            $password,
            $enabled
        );

        $encodedPassword = $this->generatePassword->generate($user, $password);
        $user->setPassword($encodedPassword);

        $this->repository->save($user);

        return $user;
    }

    private function ensureUserExists(string $username): void
    {
        ($this->verifyUserNotExist)($username);
    }
}
