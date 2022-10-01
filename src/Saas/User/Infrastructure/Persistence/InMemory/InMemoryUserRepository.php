<?php

namespace App\Saas\User\Infrastructure\Persistence\InMemory;

use App\Saas\User\Domain\Entity\User;
use App\Saas\User\Domain\Repository\UserRepository;
use Symfony\Component\Uid\Uuid;

class InMemoryUserRepository implements UserRepository
{
    /** @var User[] */
    protected array $user = [];

    public function save(User $user): void
    {
        $this->user[$user->getId()->toRfc4122()] = $user;
    }

    public function delete(User $user): void
    {
        unset($this->user[$user->getId()->toRfc4122()]);
    }

    public function search(Uuid $id): ?User
    {
        return $this->user[$id->toRfc4122()] ?? null;
    }

    /**
     * @return User[]
     */
    public function getAll(): array
    {
        return $this->user;
    }
}
