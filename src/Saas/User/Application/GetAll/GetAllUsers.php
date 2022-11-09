<?php

namespace App\Saas\User\Application\GetAll;

use App\Saas\User\Domain\User;
use App\Saas\User\Domain\UserRepository;

class GetAllUsers
{
    public function __construct(
        private readonly UserRepository $contactRepository,
    ) {
    }

    /**
     * @return User[]
     */
    public function __invoke(): array
    {
        return $this->contactRepository->getAll();
    }
}
