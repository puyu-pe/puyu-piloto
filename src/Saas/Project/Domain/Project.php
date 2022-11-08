<?php

namespace App\Saas\Project\Domain;

use App\Saas\Customer\Domain\Customer;
use App\Saas\Product\Domain\Product;
use App\Shared\Domain\Traits\SoftDeleteable;
use App\Shared\Domain\Traits\Timestampable;
use App\Shared\Domain\ValueObjects\Uuid;
use DateTime;

class Project
{
    use Timestampable;
    use SoftDeleteable;

    public function __construct(
        private readonly Uuid $id,
        private Customer $customer,
        private Product $product,
        private string $key,
        private DateTime $startDate,
        private string $logo,
        private string $color,
        private string $description,
        private string $observation,
        private string $configData,
        private bool $suspended
    ) {
    }

    public static function create(
        Customer $customer,
        Product $product,
        string $key,
        DateTime $startDate,
        string $logo,
        string $color,
        string $description,
        string $observation,
        string $configData,
        bool $suspended
    ): self {
        return new self(
            Uuid::v4(),
            $customer,
            $product,
            $key,
            $startDate,
            $logo,
            $color,
            $description,
            $observation,
            $configData,
            $suspended
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): Project
    {
        $this->key = $key;
        return $this;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): Project
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): Project
    {
        $this->logo = $logo;
        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): Project
    {
        $this->color = $color;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Project
    {
        $this->description = $description;
        return $this;
    }

    public function getObservation(): string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): Project
    {
        $this->observation = $observation;
        return $this;
    }

    public function getConfigData(): string
    {
        return $this->configData;
    }

    public function setConfigData(string $configData): Project
    {
        $this->configData = $configData;
        return $this;
    }

    public function isSuspended(): bool
    {
        return $this->suspended;
    }

    public function setSuspended(bool $suspended): Project
    {
        $this->suspended = $suspended;
        return $this;
    }
}
