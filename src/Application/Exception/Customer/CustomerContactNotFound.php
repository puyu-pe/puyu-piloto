<?php

namespace App\Application\Exception\Customer;

use Exception;

class CustomerContactNotFound extends Exception
{
    /**
     * @throws CustomerContactNotFound
     */
    public static function throwException(int $id): void
    {
        throw new self('Contacto de cliente no encontrado con id: ' . $id);
    }
}
