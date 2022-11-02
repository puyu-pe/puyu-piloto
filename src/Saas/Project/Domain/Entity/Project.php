<?php

namespace App\Saas\Project\Domain\Entity;

use App\Saas\Customer\Domain\Customer;
use App\Shared\Domain\ValueObjects\Uuid;

class Project
{
    public function __construct(
        private readonly Uuid $id,
        private \App\Saas\Customer\Domain\Customer $customer,
        private \App\Saas\Product\Domain\Product $product,
    ) {
    }

    public static function create(
        \App\Saas\Customer\Domain\Customer $customer,
        \App\Saas\Product\Domain\Product $product,
    ): self {
        return new self(
            Uuid::v4(),
            $customer,
            $product,
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCustomer(): \App\Saas\Customer\Domain\Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    public function getProduct(): \App\Saas\Product\Domain\Product
    {
        return $this->product;
    }

    public function setProduct(\App\Saas\Product\Domain\Product $product): self
    {
        $this->product = $product;
        return $this;
    }
}
