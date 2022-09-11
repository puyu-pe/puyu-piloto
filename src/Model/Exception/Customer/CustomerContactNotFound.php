<?php

namespace App\Model\Exception\Customer;

use Exception;

class CustomerContactNotFound extends Exception
{
    /**
     * @throws CustomerContactNotFound
     */
    public static function throwException(): void
    {
        throw new self('Contacto de cliente no encontrado');
    }
}
