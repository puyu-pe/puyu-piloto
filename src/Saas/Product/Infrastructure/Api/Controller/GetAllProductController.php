<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\GetAll\GetAllProducts;
use App\Saas\Product\Domain\Product;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class GetAllProductController extends ApiController
{
    /**
     * Get all products
     *
     * Get all products
     */
    #[Rest\Get(path: '', name: 'product_get_all')]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(
                    property: 'data',
                    properties: [
                        new OA\Property(
                            property: 'Products',
                            title: 'product',
                            type: 'array',
                            items: new OA\Items(ref: new Model(type: Product::class))
                        )
                    ],
                    type: 'object',
                )
            ]
        )
    )]
    #[OA\Tag(name: 'Product')]
    public function __invoke(
        GetAllProducts $useCase,
    ): Response {
        $products = ($useCase)();

        $view = View::create(
            ['products' => $products],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['product']);

        return $this->handleView($view);
    }
}
