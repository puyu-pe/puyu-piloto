<?php

namespace App\Saas\User\Application\GetAll;

use App\Saas\User\Domain\Entity\User;
use App\Saas\User\Domain\Repository\UserRepository;

class GetAllUsersUseCase
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
