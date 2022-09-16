<?php

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Model\Exception\Customer\CustomerNotFound;
use App\Repository\CustomerRepository;
use App\Service\Customer\GetCustomer;
use App\Service\Customer\SaveCustomer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


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


}





