<?php

namespace App\Saas\Customer\Infrastructure\Api\Controller;

use App\Saas\Customer\Application\GetAll\GetAllCustomer;
use App\Saas\Customer\Domain\Customer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class GetAllCustomerController extends AbstractFOSRestController
{
    /**
     * Get all customer
     *
     * Get all customer
     */
    #[Rest\Get(path: '', name: 'customer_get_all')]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(
                    property: 'data',
                    properties: [
                        new OA\Property(
                            property: 'Customers',
                            title: 'customer',
                            type: 'array',
                            items: new OA\Items(ref: new Model(type: Customer::class, groups: ['customer']))
                        )
                    ],
                    type: 'object',
                )
            ]
        )
    )]
    #[OA\Tag(name: 'Customer')]
    public function __invoke(
        GetAllCustomer $useCase,
    ): Response {
        $customer = ($useCase)();

        $view = View::create(
            ['customers' => $customer],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['customer']);

        return $this->handleView($view);
    }
}
