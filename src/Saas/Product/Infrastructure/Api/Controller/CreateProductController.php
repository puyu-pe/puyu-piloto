<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\Create\CreateProductDto;
use App\Saas\Product\Application\Create\CreateProductUseCase;
use App\Saas\Product\Domain\Exception\ProductDataException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateProductController extends AbstractFOSRestController
{
    #[Rest\Post(name: 'product_save')]
    public function __invoke(
        CreateProductUseCase $useCase,
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
