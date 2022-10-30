<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Types;

use App\Shared\Domain\ValueObjects\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\BinaryType;

final class UuidType extends BinaryType
{
    public const BINARY_LENGTH = 16;

    /**
     * @param mixed[] $column
     */
    public function getSqlDeclaration(array $column, AbstractPlatform $platform): string
    {
        return sprintf('BINARY(%d) COMMENT \'(DC2Type:uuid)\'', $column['length'] ?? self::BINARY_LENGTH);
    }

    /**
     * @param string $value
     */
    public function convertToPhpValue($value, AbstractPlatform $platform): Uuid
    {
        return Uuid::fromString($value);
    }

    /**
     * @param Uuid $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->toBinary();
    }

    public function getName(): string
    {
        return 'uuid';
    }
}
