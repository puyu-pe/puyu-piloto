<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;
use Stringable;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

class Uuid implements Stringable, JsonSerializable
{
    final public function __construct(protected string $uid)
    {
    }

    public static function fromString(string $uid): static
    {
        self::isValid($uid);
        return new static((string)SymfonyUuid::fromString($uid));
    }

    public function toBinary(): string
    {
        return SymfonyUuid::fromString($this->uid)->toBinary();
    }

    public static function v4(): static
    {
        return new static((string)SymfonyUuid::v4());
    }

    public function value(): string
    {
        return $this->uid;
    }

    public function equals(mixed $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public static function isValid(string $uid): bool
    {
        $uuid = SymfonyUuid::fromString($uid);
        if (!SymfonyUuid::isValid((string)$uuid)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $uid));
        }
        return true;
    }

    public function jsonSerialize(): string
    {
        return $this->uid;
    }
}
