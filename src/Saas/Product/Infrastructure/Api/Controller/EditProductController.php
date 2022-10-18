<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\Create\CreateProductDto;
use App\Saas\Product\Application\Edit\EditProduct;
use App\Saas\Product\Application\Edit\EditProductDto;
use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Exception\ProductDataException;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class EditProductController extends ApiController
{
    /**
     * Edit a product
     *
     * Edit a product
     */
    #[Rest\Put(path: '/{id}', name: 'product_update', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\RequestBody(content: new Model(type: CreateProductDto::class))]
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
        string $id,
        Request $request,
        EditProduct $useCase,
        SerializerInterface $serializer,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), EditProductDto::class, 'json');
            $product = ($useCase)($id, $dto);

            $view = View::create(
                ['product' => $product],
                Response::HTTP_ACCEPTED
            );
            $view->getContext()->setGroups(['product']);
        } catch (ProductNotFound|ProductDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
