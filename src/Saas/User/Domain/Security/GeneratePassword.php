<?php

namespace App\Saas\User\Domain\Security;

use App\Saas\User\Domain\Entity\User;

interface GeneratePassword
{
    public function generate(User $user, string $password): string;
}
