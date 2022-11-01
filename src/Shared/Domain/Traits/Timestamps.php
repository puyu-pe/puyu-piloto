<?php

declare(strict_types=1);

namespace App\Shared\Domain\Traits;

use DateTime;
use DateTimeInterface;

trait Timestamps
{
    private ?DateTimeInterface $createdAt;

    private ?DateTimeInterface $updatedAt;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $timestamp): self
    {
        $this->createdAt = $timestamp;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $timestamp): self
    {
        $this->updatedAt = $timestamp;
        return $this;
    }

    public function setCreatedAtAutomatically(): void
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime());
        }
    }

    public function setUpdatedAtAutomatically(): void
    {
        $this->setUpdatedAt(new DateTime());
    }
}