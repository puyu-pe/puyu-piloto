<?php

namespace App\Saas\User\Application\Create;

use App\Saas\Shared\Domain\Validation\Validator;
use App\Saas\User\Domain\Exception\UserDataException;
use App\Saas\User\Domain\Security\GeneratePassword;
use App\Saas\User\Domain\User;
use App\Saas\User\Domain\UserRepository;

class CreateUser
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Validator $validator,
        private readonly GeneratePassword $generatePassword
    ) {
    }

    /**
     * @throws UserDataException
     */
    public function __invoke(
        CreateUserDto $dto,
    ): User {
        $this->guard($dto);

        $user = User::create(
            $dto->getUsername(),
            $dto->getPassword(),
            $dto->getFullName(),
            $dto->getEnabled(),
        );

        $hashedPassword = $this->generatePassword->generate(
            $user,
            $user->getPassword()
        );
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
        return $user;
    }

    /**
     * @throws UserDataException
     */
    public function guard(CreateUserDto $user): void
    {
        $errors = $this->validator->validate($user);
        if (count($errors)) {
            $error = $errors[0];
            throw new UserDataException($error->getField(), $error->getMessage());
        }
    }
}
