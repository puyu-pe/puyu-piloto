<?php

namespace App\Saas\Customer\Infrastructure\Api\Controller;

use App\Saas\Customer\Application\Create\CreateCustomerDto;
use App\Saas\Customer\Application\Edit\EditCustomer;
use App\Saas\Customer\Application\Edit\EditCustomerDto;
use App\Saas\Customer\Domain\Customer;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class EditCustomerController extends AbstractFOSRestController
{
    /**
     * Edit a customer
     *
     * Edit a customer
     */
    #[Rest\Put(path: '/{id}', name: 'customer_update', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\RequestBody(content: new Model(type: CreateCustomerDto::class))]
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
        string $id,
        Request $request,
        EditCustomer $useCase,
        SerializerInterface $serializer,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), EditCustomerDto::class, 'json');
            $customer = ($useCase)($id, $dto);

            $view = View::create(
                ['customer' => $customer],
                Response::HTTP_ACCEPTED
            );
            $view->getContext()->setGroups(['customer']);
        } catch (CustomerNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
