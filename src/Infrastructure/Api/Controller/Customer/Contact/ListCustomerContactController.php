<?php

namespace App\Infrastructure\Api\Controller\Customer\Contact;

use App\Application\Customer\Contact\List\ListCustomerContactsUseCase;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ListCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/customer_contact', name: 'customer_contact_list')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function __invoke(
        ListCustomerContactsUseCase $useCase,
    ): Response {
        $customerContacts = ($useCase)();

        $view = View::create(
            ['customerContacts' => $customerContacts],
            Response::HTTP_OK
        );

        return $this->handleView($view);
    }
}
