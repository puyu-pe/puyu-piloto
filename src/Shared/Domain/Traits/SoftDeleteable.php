<?php

declare(strict_types=1);

namespace App\Shared\Domain\Traits;

use DateTimeInterface;

trait SoftDeleteable
{
    protected ?DateTimeInterface $deletedAt;

    public function setDeletedAt(?DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function isDeleted(): bool
    {
        return null !== $this->deletedAt;
    }
}