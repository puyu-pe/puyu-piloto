<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

class Uuid extends AbstractUid implements Stringable
{
    final public function __construct(private readonly string $value)
    {
    }

    public static function create(?string $value): ?static
    {
        if (null === $value) {
            return null;
        }

        self::ensureIsValidUuid($value);

        return new static($value);
    }

    public static function v4(): static
    {
        return new static((string)SymfonyUuid::v4());
    }

    public function value(): string
    {
        return SymfonyUuid::fromString($this->value)->toBinary();
    }

    public function equals(mixed $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return (string)SymfonyUuid::fromBinary($this->value());
    }

    private static function ensureIsValidUuid(string $id): void
    {
        $uuid = SymfonyUuid::fromBinary($id);
        if (!SymfonyUuid::isValid((string)$uuid)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }

    public static function isValid(string $uid): bool
    {
        $uuid = SymfonyUuid::fromBinary($uid);
        if (!SymfonyUuid::isValid((string)$uuid)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
        return true;
    }

    public static function fromString(string $uid): static
    {
        return new static((string)SymfonyUuid::fromString($uid));
    }

    public function toBinary(): string
    {
//        return SymfonyUuid::fromString($this->value)->toBinary();
    }
}