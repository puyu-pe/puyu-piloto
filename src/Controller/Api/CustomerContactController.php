<?php

namespace App\Controller\Api;

use App\Entity\CustomerContact;
use App\Model\Exception\Customer\CustomerContactNotFound;
use App\Repository\CustomerContactRepository;
use App\Service\Customer\Contact\DeleteCustomerContact;
use App\Service\Customer\Contact\EditCustomerContact;
use App\Service\Customer\Contact\GetCustomerContact;
use App\Service\Customer\Contact\SaveCustomerContact;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerContactController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/customer_contact', name: 'customer_contact_list')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function getAction(
        CustomerContactRepository $customerContactRepository,
    ): array
    {
        return $customerContactRepository->findAll();
    }

    #[Rest\Get(path: '/customer_contact/{id}', name: 'customer_contact_single')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function getSingleAction(
        int                $id,
        GetCustomerContact $getCustomerContact,
    ): CustomerContact|View
    {
        try {
            $customerContact = ($getCustomerContact)($id);
            return View::create($customerContact, Response::HTTP_ACCEPTED);
        } catch (CustomerContactNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    #[Rest\Post(path: '/customer_contact', name: 'customer_contact_save')]
    public function postAction(
        SaveCustomerContact $saveCustomerContact,
        Request             $request,
    ): View
    {
        [$customerContact, $error] = ($saveCustomerContact)($request);
        $statusCode = $customerContact ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $customerContact ?? $error;
        return View::create($data, $statusCode);
    }


    #[Rest\Put(path: '/customer_contact/{id}', name: 'customer_contact_update', requirements: ['id' => '\d+'])]
    public function editAction(
        int                 $id,
        Request             $request,
        EditCustomerContact $editCustomerContact,
    ): View
    {
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
        int                         $id,
        DeleteCustomerContact $deleteCustomerContact
    ): View
    {
        try {
            ($deleteCustomerContact)($id);
        } catch (CustomerContactNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}