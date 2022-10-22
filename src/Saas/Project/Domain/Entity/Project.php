<?php

namespace App\Saas\Project\Domain\Entity;

use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Product\Domain\Entity\Product;
use Symfony\Component\Uid\Uuid;

class Project
{
    public function __construct(
        private readonly Uuid $id,
        private Customer $customer,
        private Product $product,
    ) {
    }

    public static function create(
        Customer $customer,
        Product $product,
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


}
