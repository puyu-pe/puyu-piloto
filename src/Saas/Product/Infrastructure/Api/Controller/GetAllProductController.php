<?php

namespace App\Saas\Product\Infrastructure\Api\Controller;

use App\Saas\Product\Application\GetAll\GetAllProducts;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class GetAllProductController extends AbstractFOSRestController
{
    #[Rest\Get(path: '', name: 'product_get_all')]
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
