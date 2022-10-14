<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\Find\FindProduct;
use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class FindProductController extends ApiController
{
    /**
     * Find a product
     *
     * Find a product
     */
    #[Rest\Get(path: '/{id}', name: 'product_find', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(property: 'data', ref: new Model(type: Product::class))
            ]
        )
    )]
    #[OA\Tag(name: 'Product')]
    public function __invoke(
        Uuid $id,
        FindProduct $useCase,
    ): Response {
        try {
            $product = ($useCase)($id);

            $view = View::create(
                ['product' => $product],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['product']);
        } catch (ProductNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
