<?php

declare(strict_types=1);

namespace App\Shared\Domain\Traits;

use DateTimeInterface;

trait Timestampable
{
    private DateTimeInterface $createdAt;

    private DateTimeInterface $updatedAt;


    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $timestamp): self
    {
        $this->createdAt = $timestamp;
        return $this;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $timestamp): self
    {
        $this->updatedAt = $timestamp;
        return $this;
    }
}
