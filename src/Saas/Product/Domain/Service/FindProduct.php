<?php

namespace App\Saas\Product\Domain\Service;

use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Product;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class FindProduct
{
    public function __construct(
        private readonly ProductRepository $repository
    ) {
    }

    /**
     * @throws ProductNotFound
     */
    public function __invoke(string $id): Product
    {
        $product = $this->repository->search(Uuid::fromString($id));

        $this->guard($id, $product);

        return $product;
    }

    /**
     * @throws ProductNotFound
     */
    private function guard(string $id, Product $product = null): void
    {
        if (is_null($product)) {
            throw new ProductNotFound($id);
        }
    }
}
