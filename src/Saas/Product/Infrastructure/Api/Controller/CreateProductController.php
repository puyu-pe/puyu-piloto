<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\Create\CreateProduct;
use App\Saas\Product\Application\Create\CreateProductDto;
use App\Saas\Product\Domain\Exception\ProductDataException;
use App\Saas\Product\Domain\Product;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateProductController extends ApiController
{
    /**
     * Add new product
     *
     * Add new product
     */
    #[Rest\Post(name: 'product_save')]
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
        CreateProduct $useCase,
        SerializerInterface $serializer,
        Request $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateProductDto::class, 'json');
            $product = ($useCase)($dto);

            $view = View::create(
                ['product' => $product],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['product']);
        } catch (ProductDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
