<?php

namespace App\Service\Product;

use App\Model\Exception\Product\ProductNotFound;
use Doctrine\ORM\EntityManagerInterface;

class DeleteProduct
{
    public function __construct(
        private readonly GetProduct             $getProduct,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws ProductNotFound
     */
    public function __invoke(int $id): void
    {
        $product = ($this->getProduct)($id);
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}
