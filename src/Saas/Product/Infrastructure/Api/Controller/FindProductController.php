<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\Find\FindProduct;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class FindProductController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/{id}', name: 'product_find', requirements: ['id' => Requirement::UUID_V4])]
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
