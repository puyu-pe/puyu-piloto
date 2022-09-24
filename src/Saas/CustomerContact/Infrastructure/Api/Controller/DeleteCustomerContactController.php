<?php

namespace App\Saas\CustomerContact\Infrastructure\Api\Controller;

use App\Saas\CustomerContact\Application\Delete\DeleteCustomerContactUseCase;
use App\Saas\CustomerContact\Domain\Exception\ProductNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Delete(path: '/{id}', name: 'customer_contact_delete', requirements: ['id' => Requirement::UUID_V4])]
    public function __invoke(
        string $id,
        DeleteCustomerContactUseCase $useCase,
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
