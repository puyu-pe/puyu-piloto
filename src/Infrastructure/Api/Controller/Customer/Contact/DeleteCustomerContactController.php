<?php

namespace App\Infrastructure\Api\Controller\Customer\Contact;

use App\Application\Customer\Contact\Delete\DeleteCustomerContactUseCase;
use App\Domain\Exception\Customer\Contact\CustomerContactNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Delete(path: '/customer_contact/{id}', name: 'customer_contact_delete', requirements: ['id' => Requirement::UUID_V4])]
    public function __invoke(
        string $id,
        DeleteCustomerContactUseCase $useCase,
    ): Response {
        try {
            ($useCase)($id);
            $view = View::create(null, Response::HTTP_OK);
        } catch (CustomerContactNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
