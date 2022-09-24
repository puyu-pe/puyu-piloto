<?php

namespace App\Model\Exception\User;

use Exception;

class UserNotFound extends Exception
{
    /**
     * @throws UserNotFound
     */
    public static function throwException(): void
    {
        throw new self('Usuario no encontrado');
    }
}
