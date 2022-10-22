<?php

namespace App\Saas\User\Domain\Security;

use App\Saas\User\Domain\User;

interface GeneratePassword
{
    public function generate(User $user, string $password): string;
}
