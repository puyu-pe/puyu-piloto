<?php

namespace App\Controller\Api;

use App\Entity\Product;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use App\Model\Exception\Product\ProductNotFound;
use Symfony\Component\HttpFoundation\Response;

use App\Service\Product\GetProduct;

class ProductController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/product', name: 'product_list')]
    #[Rest\View(serializerGroups: ['product'])]
    public function getAction(
        ProductRepository $productRepository,
    ): array
    {
        return $productRepository->findAll();
    }

    #[Rest\Get(path: '/product/{id}', name: 'product_single')]
    #[Rest\View(serializerGroups: ['product'])]
    public function getSingleAction(
        int        $id,
        GetProduct $getProduct,
    ): Product|View
    {
        try {
            $product = ($getProduct)($id);
            return View::create($product, Response::HTTP_ACCEPTED);
        } catch (ProductNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
