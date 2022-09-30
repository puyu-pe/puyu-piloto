<?php

namespace App\Saas\Customer\Infrastructure\Api\Controller;

use App\Saas\Customer\Application\GetAll\GetAllCustomerUseCase;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class GetAllCustomerController extends AbstractFOSRestController
{
    #[Rest\Get(path: '', name: 'customer_get_all')]
    public function __invoke(
        GetAllCustomerUseCase $useCase,
    ): Response {
        $customer = ($useCase)();

        $view = View::create(
            ['customerContacts' => $customer],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['customer']);

        return $this->handleView($view);
    }
}
