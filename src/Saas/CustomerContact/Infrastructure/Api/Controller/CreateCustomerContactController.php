<?php

namespace App\Saas\CustomerContact\Infrastructure\Api\Controller;

use App\Saas\CustomerContact\Application\Create\CreateCustomerContact;
use App\Saas\CustomerContact\Application\Create\CreateCustomerContactDto;
use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Exception\CustomerContactDataException;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class CreateCustomerContactController extends ApiController
{
    /**
     * Add new customer contact
     *
     * Add new customer contact
     */
    #[Rest\Post(name: 'customer_contact_save')]
    #[OA\RequestBody(content: new Model(type: CreateCustomerContactDto::class))]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(property: 'data', ref: new Model(type: CustomerContact::class))
            ]
        )
    )]
    #[OA\Tag(name: 'CustomerContact')]
    public function __invoke(
        CreateCustomerContact $useCase,
        SerializerInterface $serializer,
        Request $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateCustomerContactDto::class, 'json');
            $customerContact = ($useCase)($dto);

            $view = View::create(
                ['customerContact' => $customerContact],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['customer_contact']);
        } catch (CustomerContactDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
