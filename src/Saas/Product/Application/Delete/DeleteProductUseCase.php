<?php

namespace App\Saas\Product\Application\Delete;

use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Saas\Product\Domain\Service\FindProduct;

class DeleteProductUseCase
{
    private FindProduct $finder;

    public function __construct(
        private readonly ProductRepository $repository
    ) {
        $this->finder = new FindProduct($repository);
    }

    /**
     * @throws ProductNotFound
     */
    public function __invoke(string $id): void
    {
        $product = ($this->finder)($id);
        $this->repository->delete($product);
    }
}
