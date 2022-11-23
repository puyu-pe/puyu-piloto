<?php

declare(strict_types=1);

namespace App\Saas\User\Application\Command\Create;

use App\Saas\User\Domain\User;
use App\Shared\Domain\Bus\Command\CommandHandler;

final class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CreateUser $service
    ) {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = ($this->service)(
            $command->getId(),
            $command->getUsername(),
            $command->getPassword(),
            $command->getFullName(),
            $command->getEnabled()
        );

        return $user;
    }
}
