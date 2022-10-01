<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\Edit\EditProduct;
use App\Saas\Product\Application\Edit\EditProductDto;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class EditProductController extends AbstractFOSRestController
{
    #[Rest\Put(path: '/{id}', name: 'product_update', requirements: ['id' => Requirement::UUID_V4])]
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
        } catch (ProductNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
