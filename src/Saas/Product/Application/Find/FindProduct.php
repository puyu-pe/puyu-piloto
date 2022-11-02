<?php

namespace App\Saas\Product\Application\Find;

use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Product;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Saas\Product\Domain\Service\FindProduct as DomainFindProduct;

class FindProduct
{
    private DomainFindProduct $finder;

    public function __construct(
        ProductRepository $productRepository,
    ) {
        $this->finder = new DomainFindProduct($productRepository);
    }

    /**
     * @throws ProductNotFound
     */
    public function __invoke(string $id): Product
    {
        return ($this->finder)($id);
    }
}
