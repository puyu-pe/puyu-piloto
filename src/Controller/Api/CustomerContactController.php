<?php

namespace App\Controller\Api;

use App\Model\Exception\Customer\CustomerContactDataException;
use App\Model\Exception\Customer\CustomerContactNotFound;
use App\Service\Customer\Contact\CreateCustomerContact;
use App\Service\Customer\Contact\DeleteCustomerContact;
use App\Service\Customer\Contact\Dto\CustomerContactDto;
use App\Service\Customer\Contact\EditCustomerContact;
use App\Service\Customer\Contact\GetCustomerContactById;
use App\Service\Customer\Contact\GetCustomerContacts;
use App\Utils\FOSRest\FOSRestCustomController;
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

    #[Rest\Get(path: '/customer_contact/{id}', name: 'customer_contact_single')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function getSingleAction(
        int $id,
        GetCustomerContactById $getCustomerContactById,
    ): Response {
        try {
            $customerContact = $getCustomerContactById($id);
            return $this->HttpResponse($customerContact, Response::HTTP_ACCEPTED);
        } catch (CustomerContactNotFound $e) {
            return $this->HttpResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    #[Rest\Post(path: '/customer_contact', name: 'customer_contact_save')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function postAction(
        CreateCustomerContact $createCustomerContact,
        Request $request,
    ): Response {
        try {
            $customerContactDto = CustomerContactDto::fromRequest($request);
            $customerContact = $createCustomerContact($customerContactDto);
            return $this->HttpResponse($customerContact, Response::HTTP_CREATED);
        } catch (CustomerContactDataException $e) {
            return $this->HttpResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->HttpResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Rest\Put(path: '/customer_contact/{id}', name: 'customer_contact_update', requirements: ['id' => '\d+'])]
    public function editAction(
        int $id,
        Request $request,
        EditCustomerContact $editCustomerContact,
    ): View {
        try {
            [$customerContact, $error] = ($editCustomerContact)($request, $id);
            $statusCode = $customerContact ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
            $data = $customerContact ?? $error;
            return View::create($data, $statusCode);
        } catch (CustomerContactNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Rest\Delete(path: '/customer_contact/{id}', name: 'customer_contact_delete', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int $id,
        DeleteCustomerContact $deleteCustomerContact
    ): View {
        try {
            ($deleteCustomerContact)($id);
        } catch (CustomerContactNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
