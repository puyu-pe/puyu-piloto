<?php

namespace App\Saas\Product\Application\GetAll;

use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Saas\Product\Domain\Service\FindProduct;

class GetProduct
{
    private FindProduct $finder;

    public function __construct(
        ProductRepository $customerContactRepository,
    ) {
        $this->finder = new FindProduct($customerContactRepository);
    }

    /**
     * @throws ProductNotFound
     */
    public function __invoke(string $id): Product
    {
        return ($this->finder)($id);
    }
}
