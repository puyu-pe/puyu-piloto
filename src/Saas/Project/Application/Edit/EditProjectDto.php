<?php

namespace App\Saas\Project\Application\Edit;

use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Product\Domain\Entity\Product;

class EditProjectDto
{
    public function __construct(
        private readonly ?Customer $customer = null,
        private readonly ?Product $product = null,
    ) {
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }
}
