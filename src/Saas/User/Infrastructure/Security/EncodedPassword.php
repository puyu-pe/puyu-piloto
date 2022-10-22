<?php

namespace App\Saas\User\Infrastructure\Security;

use App\Saas\User\Domain\Security\GeneratePassword;
use App\Saas\User\Domain\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class EncodedPassword implements GeneratePassword
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->encoder = $passwordHasher;
    }

    public function generate(User $user, string $password): string
    {
        $authUser = new Auth($user->getUsername(), $password);
        return $this->encoder->hashPassword($authUser, $password);
    }
}
