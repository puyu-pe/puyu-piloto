<?php

namespace App\Saas\CustomerContact\Infrastructure\Api\Controller;

use App\Saas\CustomerContact\Application\Create\CreateCustomerContactDto;
use App\Saas\CustomerContact\Application\Edit\EditCustomerContact;
use App\Saas\CustomerContact\Application\Edit\EditCustomerContactDto;
use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Exception\CustomerContactNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

class EditCustomerContactController extends AbstractFOSRestController
{
    /**
     * Edit a customer contact
     *
     * Edit a customer contact
     */
    #[Rest\Put(path: '/{id}', name: 'customer_contact_update', requirements: ['id' => Requirement::UUID_V4])]
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
        string $id,
        Request $request,
        EditCustomerContact $useCase,
        SerializerInterface $serializer,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), EditCustomerContactDto::class, 'json');
            $customerContact = ($useCase)($id, $dto);

            $view = View::create(
                ['customerContact' => $customerContact],
                Response::HTTP_ACCEPTED
            );
            $view->getContext()->setGroups(['customer_contact']);
        } catch (CustomerContactNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
