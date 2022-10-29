<?php

namespace App\Saas\Customer\Infrastructure\Api\Controller;

use App\Saas\Customer\Application\Find\FindCustomer;
use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class FindCustomerController extends AbstractFOSRestController
{
    /**
     * Find a customer
     *
     * Find a customer
     */
    #[Rest\Get(path: '/{id}', name: 'customer_find', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(property: 'data', ref: new Model(type: Customer::class, groups: ['customer']))
            ]
        )
    )]
    #[OA\Tag(name: 'Customer')]
    public function __invoke(
        Uuid $id,
        FindCustomer $useCase,
    ): Response {
        try {
            $customer = ($useCase)($id);

            $view = View::create(
                ['customer' => $customer],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['customer']);
        } catch (CustomerNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
