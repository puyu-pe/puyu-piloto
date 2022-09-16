<?php

namespace App\Model\Exception\Product;

use Exception;

class ProductNotFound extends Exception
{
    /**
     * @throws ProductNotFound
     */
    public static function throwException(): void
    {
        throw new self('Producto no encontrado.');
    }
}
