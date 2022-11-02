<?php

namespace App\Saas\Customer\Infrastructure\Api\Controller;

use App\Saas\Customer\Application\Create\CreateCustomer;
use App\Saas\Customer\Application\Create\CreateCustomerDto;
use App\Saas\Customer\Domain\Customer;
use App\Saas\Customer\Domain\Exception\CustomerDataException;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateCustomerController extends ApiController
{
    /**
     * Add new customer
     *
     * Add new customer
     */
    #[Rest\Post(name: 'customer_save')]
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
        CreateCustomer $useCase,
        SerializerInterface $serializer,
        Request $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateCustomerDto::class, 'json');
            $customer = ($useCase)($dto);

            $view = View::create(
                ['customer' => $customer],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['customer']);
        } catch (CustomerDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
