<?php

namespace App\Saas\Product\Application\GetAll;

use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Repository\ProductRepository;

class GetAllProducts
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    /**
     * @return Product[]
     */
    public function __invoke(): array
    {
        return $this->productRepository->getAll();
    }
}
