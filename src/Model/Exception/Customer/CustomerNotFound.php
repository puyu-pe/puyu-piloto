<?php

namespace App\Model\Exception\Customer;

use Exception;

class CustomerNotFound extends Exception
{
    /**
     * @throws CustomerNotFound
     */
    public static function throwException(): void
    {
        throw new self('Cliente no encontrado');
    }
}
