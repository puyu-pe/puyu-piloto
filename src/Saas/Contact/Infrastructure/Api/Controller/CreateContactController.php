<?php

namespace App\Saas\Contact\Infrastructure\Api\Controller;

use App\Saas\Contact\Application\Create\CreateContact;
use App\Saas\Contact\Application\Create\CreateContactDto;
use App\Saas\Contact\Domain\Contact;
use App\Saas\Contact\Domain\Exception\ContactDataException;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateContactController extends ApiController
{
    /**
     * Add new contact
     *
     * Add new contact
     */
    #[Rest\Post(name: 'contact_save')]
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
        CreateContact       $useCase,
        SerializerInterface $serializer,
        Request             $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateContactDto::class, 'json');
            $contact = ($useCase)($dto);

            $view = View::create(
                ['contact' => $contact],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['contact']);
        } catch (ContactDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
