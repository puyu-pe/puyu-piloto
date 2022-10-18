<?php

namespace App\Auth\User\Domain\Service;

use App\Saas\User\Infrastructure\Persistence\Doctrine\Repository\DoctrineUserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Login implements UserProviderInterface
{
    public function __construct(
        private readonly DoctrineUserRepository $userRepository,
    ) {
    }

    public function supportsClass($class): bool
    {
        return $class === DoctrineUserRepository::class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if (null === ($user = $this->userRepository->findOneBy(['username' => $identifier]))) {
            throw new UserNotFoundException(sprintf('No user found for "%s"', $identifier));
        }
        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof DoctrineUserRepository) {
            throw new UnsupportedUserException(sprintf('Invalid user class %s', \get_class($user)));
        }

        $userEntity = $this->userRepository->findOneBy(['username' => $user->getUserIdentifier()]);
        if (!$userEntity) {
            throw new UserNotFoundException(sprintf('No user found for "%s"', $user->getUsername()));
        }

        return $userEntity;
    }

}