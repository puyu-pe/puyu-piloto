<?php

namespace App\Saas\Product\Infrastructure\Persistence\InMemory;

use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Shared\Domain\ValueObjects\Uuid;

class InMemoryProductRepository implements ProductRepository
{
    /** @var Product[] */
    protected array $products = [];

    public function save(Product $product): void
    {
        $this->products[$product->getId()->toRfc4122()] = $product;
    }

    public function delete(Product $product): void
    {
        unset($this->products[$product->getId()->toRfc4122()]);
    }

    public function search(Uuid $id): ?Product
    {
        return $this->products[$id->toRfc4122()] ?? null;
    }

    /**x
     * @return Product[]
     */
    public function getAll(): array
    {
        return $this->products;
    }
}
