<?php

namespace App\Saas\Customer\Infrastructure\Api\Controller;

use App\Saas\Customer\Application\Delete\DeleteCustomer;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteCustomerController extends AbstractFOSRestController
{
    #[Rest\Delete(path: '/{id}', name: 'customer_delete', requirements: ['id' => Requirement::UUID_V4])]
    public function __invoke(
        string $id,
        DeleteCustomer $useCase,
    ): Response {
        try {
            ($useCase)($id);
            $view = View::create(null, Response::HTTP_OK);
        } catch (CustomerNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
