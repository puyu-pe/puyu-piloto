<?php

namespace App\Saas\Project\Application\Edit;

class EditProjectDto
{
    public function __construct(
        private readonly ?string $customerId = null,
        private readonly ?string $productId = null,
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
}
