<?php

namespace App\Saas\Contact\Infrastructure\Api\Controller;

use App\Saas\Contact\Application\Create\CreateContactDto;
use App\Saas\Contact\Application\Edit\EditContact;
use App\Saas\Contact\Application\Edit\EditContactDto;
use App\Saas\Contact\Domain\Contact;
use App\Saas\Contact\Domain\Exception\ContactDataException;
use App\Saas\Contact\Domain\Exception\ContactNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class EditContactController extends AbstractFOSRestController
{
    /**
     * Edit a contact
     *
     * Edit a contact
     */
    #[Rest\Put(path: '/{id}', name: 'contact_update', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\RequestBody(content: new Model(type: CreateContactDto::class))]
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
        string              $id,
        Request             $request,
        EditContact         $useCase,
        SerializerInterface $serializer,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), EditContactDto::class, 'json');
            $contact = ($useCase)($id, $dto);

            $view = View::create(
                ['contact' => $contact],
                Response::HTTP_ACCEPTED
            );
            $view->getContext()->setGroups(['contact']);
        } catch (ContactNotFound|ContactDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
