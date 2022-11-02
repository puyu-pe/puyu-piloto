<?php

namespace App\Saas\Product\Application\GetAll;

use App\Saas\Product\Domain\Product;
use App\Saas\Product\Domain\Repository\ProductRepository;

class GetAllProducts
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    /**
     * @return \App\Saas\Product\Domain\Product[]
     */
    public function __invoke(): array
    {
        return $this->productRepository->getAll();
    }
}
