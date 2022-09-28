<?php

namespace App\Saas\Product\Domain\Service;

use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Repository\ProductRepository;
use Symfony\Component\Uid\Uuid;

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
     * @throws \App\Saas\Product\Domain\Exception\ProductNotFound
     */
    private function guard(string $id, Product $customerContact = null): void
    {
        if (is_null($customerContact)) {
            throw new ProductNotFound($id);
        }
    }
}
