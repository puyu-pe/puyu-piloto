<?php

namespace App\Saas\Project\Application\Edit;

use DateTime;

class EditProjectDto
{
    public function __construct(
        private readonly string $customerId,
        private readonly string $productId,
        private readonly string $key,
        private readonly DateTime $startDate,
        private readonly string $logo,
        private readonly string $color,
        private readonly string $configData,
        private readonly bool $suspended,
        private readonly ?string $description = null,
        private readonly ?string $observation = null
    ) {
    }

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getObservation(): string
    {
        return $this->observation;
    }

    public function getConfigData(): string
    {
        return $this->configData;
    }

    public function isSuspended(): bool
    {
        return $this->suspended;
    }
}
