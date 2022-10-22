<?php

namespace App\Saas\User\Domain\Repository;

use App\Saas\User\Domain\User;
use App\Shared\Domain\ValueObjects\Uuid;

/**
 * @ent Traversable<\Vendor\ItemInterface>
 */
interface UserRepository
{
    public function save(User $user): void;

    public function delete(User $user): void;

    public function search(Uuid $id): ?User;

    /**
     * @return User[]
     */
    public function getAll(): array;

    public function findByUsername(string $username): ?User;
}
