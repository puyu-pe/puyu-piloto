<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Types;

use App\Shared\Domain\ValueObjects\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class UuidType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;

        }
;
        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Uuid
    {
        if (null === $value) {
            return null;
        }

        return Uuid::create($value);
    }
}