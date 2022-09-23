<?php

namespace App\Saas\CustomerContact\Infrastructure\Api\Controller;

use App\Saas\CustomerContact\Application\GetAll\GetAllCustomerContactsUseCase;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class GetAllCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Get(path: '', name: 'customer_contact_get_all')]
    public function __invoke(
        GetAllCustomerContactsUseCase $useCase,
    ): Response {
        $customerContacts = ($useCase)();

        $view = View::create(
            ['customerContacts' => $customerContacts],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['customer_contact']);

        return $this->handleView($view);
    }
}
