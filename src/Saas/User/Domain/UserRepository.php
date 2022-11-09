<?php

namespace App\Saas\User\Domain;

use App\Shared\Domain\ValueObjects\Uuid;

interface UserRepository
{
    public function save(User $user): void;

    public function delete(User $user): void;

    public function search(Uuid $id): ?User;

    public function searchByUsername(string $username): ?User;

    /**
     * @return User[]
     */
    public function getAll(): array;

}
