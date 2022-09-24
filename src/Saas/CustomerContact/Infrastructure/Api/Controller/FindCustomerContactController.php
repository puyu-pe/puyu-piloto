<?php

namespace App\Saas\CustomerContact\Infrastructure\Api\Controller;

use App\Saas\CustomerContact\Application\Find\FindCustomerContactUseCase;
use App\Saas\CustomerContact\Domain\Exception\ProductNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class FindCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/{id}', name: 'customer_contact_find', requirements: ['id' => Requirement::UUID_V4])]
    public function __invoke(
        Uuid $id,
        FindCustomerContactUseCase $useCase,
    ): Response {
        try {
            $customerContact = ($useCase)($id);

            $view = View::create(
                ['customerContact' => $customerContact],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['customer_contact']);
        } catch (ProductNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
