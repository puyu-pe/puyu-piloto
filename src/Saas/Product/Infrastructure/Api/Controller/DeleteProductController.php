<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\Delete\DeleteProduct;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteProductController extends AbstractFOSRestController
{
    #[Rest\Delete(path: '/{id}', name: 'product_delete', requirements: ['id' => Requirement::UUID_V4])]
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
