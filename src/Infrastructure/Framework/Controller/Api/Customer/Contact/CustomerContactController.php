<?php

namespace App\Infrastructure\Framework\Controller\Api\Customer\Contact;

use App\Application\Exception\Customer\CustomerContactNotFound;
use App\Application\UseCase\Customer\Contact\Delete\DeleteCustomerContactUseCase;
use App\Application\UseCase\Customer\Contact\Dto\CustomerContactDto;
use App\Application\UseCase\Customer\Contact\Edit\EditCustomerContactUseCase;
use App\Application\UseCase\Customer\Contact\Get\GetCustomerContacts;
use App\Infrastructure\Utils\FOSRest\FOSRestCustomController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerContactController extends FOSRestCustomController
{
    #[Rest\Get(path: '/customer_contact', name: 'customer_contact_list')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function getAction(
        GetCustomerContacts $getCustomerContacts,
    ): Response {
        $customerContacts = $getCustomerContacts();
        return $this->HttpResponse($customerContacts, Response::HTTP_OK);
    }

//    #[Rest\Get(path: '/customer_contact/{id}', name: 'customer_contact_single')]
//    #[Rest\View(serializerGroups: ['customer_contact'])]
//    public function getSingleAction(
//        int $id,
//        FindCustomerContactUseCase $getCustomerContactById,
//    ): Response {
//        try {
//            $customerContact = $getCustomerContactById($id);
//            return $this->HttpResponse($customerContact, Response::HTTP_ACCEPTED);
//        } catch (CustomerContactNotFound $e) {
//            return $this->HttpResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
//        }
//    }

    #[Rest\Put(path: '/customer_contact/{id}', name: 'customer_contact_update', requirements: ['id' => '\d+'])]
    public function editAction(
        int $id,
        Request $request,
        EditCustomerContactUseCase $editCustomerContact,
    ): Response {
        try {
            $customerContactDto = CustomerContactDto::fromRequest($request);
            $customerContact = ($editCustomerContact)($customerContactDto, $id);
            return $this->HttpResponse($customerContact, Response::HTTP_ACCEPTED);
        } catch (CustomerContactNotFound $e) {
            return $this->HttpResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->HttpResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Rest\Delete(path: '/customer_contact/{id}', name: 'customer_contact_delete', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int $id,
        DeleteCustomerContactUseCase $deleteCustomerContact
    ): View {
        try {
            ($deleteCustomerContact)($id);
        } catch (CustomerContactNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
