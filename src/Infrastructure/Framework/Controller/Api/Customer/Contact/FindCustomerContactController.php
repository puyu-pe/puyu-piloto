<?php

namespace App\Infrastructure\Framework\Controller\Api\Customer\Contact;

use App\Application\Exception\Customer\CustomerContactNotFound;
use App\Application\UseCase\Customer\Contact\Find\FindCustomerContactCommand;
use App\Application\UseCase\Customer\Contact\Find\FindCustomerContactCommandHandler;
use App\Infrastructure\Utils\FOSRest\FOSRestCustomController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class FindCustomerContactController extends FOSRestCustomController
{
    #[Rest\Get(path: '/customer_contact/{id}', name: 'customer_contact_single')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function __invoke(
        int $id,
        FindCustomerContactCommandHandler $handler,
    ): Response {
        try {
            $command = new FindCustomerContactCommand($id);
            $customerContact = ($handler)($command);
            return $this->HttpResponse($customerContact, Response::HTTP_ACCEPTED);
        } catch (CustomerContactNotFound $e) {
            return $this->HttpResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}