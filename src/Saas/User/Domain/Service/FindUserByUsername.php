<?php

namespace App\Saas\User\Domain\Service;

use App\Saas\User\Domain\Exception\UserAlreadyExist;
use App\Saas\User\Domain\User;
use App\Saas\User\Domain\UserRepository;

class FindUserByUsername
{
    public function __construct(
        private readonly UserRepository $repository
    ) {
    }
    
    public function __invoke(string $username): ?user
    {
        return $this->repository->searchByUsername($username);
    }
}
