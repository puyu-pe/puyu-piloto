<?php

namespace App\Saas\Contact\Infrastructure\Api\Controller;

use App\Saas\Contact\Application\Delete\DeleteContact;
use App\Saas\Contact\Domain\Exception\ContactNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteContactController extends ApiController
{
    /**
     * Delete a contact
     *
     * Delete a contact
     */
    #[Rest\Delete(path: '/{id}', name: 'contact_delete', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response'
    )]
    #[OA\Tag(name: 'Contact')]
    public function __invoke(
        string $id,
        DeleteContact $useCase,
    ): Response {
        try {
            ($useCase)($id);
            $view = View::create(null, Response::HTTP_OK);
        } catch (ContactNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
