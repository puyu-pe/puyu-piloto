<?php

namespace App\Saas\CustomerContact\Infrastructure\Api\Controller;

use App\Saas\CustomerContact\Application\GetAll\GetAllCustomerContacts;
use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use OpenApi\Attributes as OA;

class GetAllCustomerContactController extends AbstractFOSRestController
{
    /**
     * Get all customer contact
     *
     * Get all customer contact
     */
    #[Rest\Get(path: '', name: 'customer_contact_get_all')]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(
                    property: 'data',
                    properties: [new OA\Property(
                        property: 'CustomerContacts',
                        title: 'customerContact',
                        type: 'array',
                        items: new OA\Items(ref: new Model(type: CustomerContact::class))
                    )],
                    type: 'object',
                )
            ]
        )
    )]
    #[OA\Tag(name: 'CustomerContact')]
    public function __invoke(
        GetAllCustomerContacts $useCase,
    ): Response {
        $customerContacts = ($useCase)();

        $view = View::create(
            ['customerContacts' => $customerContacts],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['customer_contact']);

        return $this->handleView($view);
    }
}
