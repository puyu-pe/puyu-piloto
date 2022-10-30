<?php

namespace App\Saas\Contact\Infrastructure\Api\Controller;

use App\Saas\Contact\Application\Find\FindContact;
use App\Saas\Contact\Domain\Entity\Contact;
use App\Saas\Contact\Domain\Exception\ContactNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class FindContactController extends AbstractFOSRestController
{
    /**
     * Find a contact
     *
     * Find a contact
     */
    #[Rest\Get(path: '/{id}', name: 'contact_find', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(property: 'data', ref: new Model(type: Contact::class))
            ]
        )
    )]
    #[OA\Tag(name: 'Contact')]
    public function __invoke(
        Uuid        $id,
        FindContact $useCase,
    ): Response {
        try {
            $contact = ($useCase)($id);

            $view = View::create(
                ['contact' => $contact],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['contact']);
        } catch (ContactNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
