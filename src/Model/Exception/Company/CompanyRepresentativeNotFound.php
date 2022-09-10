<?php

namespace App\Model\Exception\Company;

use Exception;

class CompanyRepresentativeNotFound extends Exception
{
    /**
     * @throws CompanyRepresentativeNotFound
     */
    public static function throwException(): void
    {
        throw new self('Company representative  not found');
    }
}