<?php

namespace App\Saas\Product\Application\Find;

use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Saas\Product\Domain\Service\FindProduct;

class FindProductUseCase
{
    private FindProduct $finder;

    public function __construct(
        ProductRepository $productRepository,
    ) {
        $this->finder = new FindProduct($productRepository);
    }

    /**
     * @throws ProductNotFound
     */
    public function __invoke(string $id): Product
    {
        return ($this->finder)($id);
    }
}
