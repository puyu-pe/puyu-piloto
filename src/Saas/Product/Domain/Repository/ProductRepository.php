<?php

namespace App\Saas\Product\Domain\Repository;

use App\Saas\Product\Domain\Product;
use App\Shared\Domain\ValueObjects\Uuid;

/**
 * @ent Traversable<\Vendor\ItemInterface>
 */
interface ProductRepository
{
    public function save(Product $product): void;

    public function delete(Product $product): void;

    public function search(Uuid $id): ?Product;

    /**
     * @return Product[]
     */
    public function getAll(): array;
}
