<?php

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Model\Exception\Customer\CustomerNotFound;
use App\Repository\CustomerRepository;
use App\Service\Customer\DeleteCustomer;
use App\Service\Customer\EditCustomer;
use App\Service\Customer\GetCustomer;
use App\Service\Customer\SaveCustomer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends AbstractFOSRestController
{
    #[Rest\Get(path:'/customer',name: 'customer')]
    #[Rest\View(serializerGroups: ['customer'])]

    public function getAction(CustomerRepository $customerRepository,
    ): array {
        return $customerRepository->findAll();
    }

    #[Rest\Get(path: '/customer/{id}', name: 'customer_single')]
    #[Rest\View(serializerGroups: ['customer'])]
    public function getSingleAction(
        int $id,
        GetCustomer $getCustomer,
    ): Customer|View {
        try {
            $customer = ($getCustomer)($id);
            return View::create($customer, Response::HTTP_ACCEPTED);
        } catch (CustomerNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Rest\Post(path: '/customer', name: 'customer_save')]
    public function postAction(
        SaveCustomer $saveCustomer,
        Request $request,
    ): View {
        [$customer, $error] = ($saveCustomer)($request);
        $statusCode = $customer ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $customer ?? $error;
        return View::create($data, $statusCode);
    }

    #[Rest\Put(path: '/customer/{id}', name: 'customer_update', requirements: ['id' => '\d+'])]
    public function editAction(
        int $id,
        Request $request,
        EditCustomer $editCustomer,
    ): View {
        try {
            [$customer, $error] = ($editCustomer)($request, $id);
            $statusCode = $customer ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
            $data = $customer ?? $error;
            return View::create($data, $statusCode);
        } catch (CustomerNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Rest\Delete(path: '/customer/{id}', name: 'customer_delete', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int $id,
        DeleteCustomer $deleteCustomer
    ): View {
        try {
            ($deleteCustomer)($id);
        } catch (CustomerNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}





