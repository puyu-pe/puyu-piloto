<?php

namespace App\Saas\User\Application\GetAll;

use App\Saas\User\Domain\Repository\UserRepository;
use App\Saas\User\Domain\User;

class GetAllUsers
{
    public function __construct(
        private readonly UserRepository $customerContactRepository,
    ) {
    }

    /**
     * @return User[]
     */
    public function __invoke(): array
    {
        return $this->customerContactRepository->getAll();
    }
}
