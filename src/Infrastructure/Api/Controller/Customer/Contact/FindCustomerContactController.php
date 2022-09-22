<?php

namespace App\Infrastructure\Api\Controller\Customer\Contact;

use App\Application\Customer\Contact\Find\FindCustomerContactUseCase;
use App\Domain\Exception\Customer\Contact\CustomerContactNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class FindCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/customer_contact/{id}', name: 'customer_contact_single', requirements: ['id' => Requirement::UUID_V4])]
    #[Rest\View(serializerGroups: ['customer_contact'])]
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
        } catch (CustomerContactNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
