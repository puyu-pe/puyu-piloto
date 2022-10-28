<?php

namespace App\Saas\Contact\Infrastructure\Api\Controller;

use App\Saas\Contact\Application\GetAll\GetAllContacts;
use App\Saas\Contact\Domain\Entity\Contact;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class GetAllContactController extends AbstractFOSRestController
{
    /**
     * Get all contact
     *
     * Get all contact
     */
    #[Rest\Get(path: '', name: 'contact_get_all')]
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
                            property: 'Contacts',
                            title: 'contact',
                            type: 'array',
                            items: new OA\Items(ref: new Model(type: Contact::class))
                        )
                    ],
                    type: 'object',
                )
            ]
        )
    )]
    #[OA\Tag(name: 'Contact')]
    public function __invoke(
        GetAllContacts $useCase,
    ): Response {
        $contact = ($useCase)();

        $view = View::create(
            ['contact' => $contact],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['contact']);

        return $this->handleView($view);
    }
}
