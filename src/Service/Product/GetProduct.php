<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Model\Exception\Product\ProductNotFound;
use App\Repository\ProductRepository;

class GetProduct
{
    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {
    }

    /**
     * @throws ProductNotFound
     */

    public function __invoke(int $id): Product
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            ProductNotFound::throwException();
        }

        return $product;
    }
}