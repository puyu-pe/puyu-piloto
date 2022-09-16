<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Repository\ProductRepository;

class ProductController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/product', name: 'product_list')]
    #[Rest\View(serializerGroups: ['product'])]
    public function getAction(
        ProductRepository $productRepository,
    ): array {
        return $productRepository->findAll();
    }
}
