<?php

namespace App\Model\Exception\Customer;

use Exception;

class CustomerContactDataException extends Exception
{
    /**
     * @throws CustomerContactDataException
     */
    public static function throwException($message): void
    {
        throw new self($message);
    }
}
