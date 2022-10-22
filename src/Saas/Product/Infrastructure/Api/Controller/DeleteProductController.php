<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\Delete\DeleteProduct;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteProductController extends ApiController
{
    /**
     * Delete a product
     *
     * Delete a product
     */
    #[Rest\Delete(path: '/{id}', name: 'product_delete', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response'
    )]
    #[OA\Tag(name: 'Product')]
    public function __invoke(
        string $id,
        DeleteProduct $useCase,
    ): Response {
        try {
            ($useCase)($id);
            $view = View::create(null, Response::HTTP_OK);
        } catch (ProductNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
