<?php

namespace App\Saas\CustomerContact\Infrastructure\Api\Controller;

use App\Saas\CustomerContact\Application\Delete\DeleteCustomerContact;
use App\Saas\CustomerContact\Domain\Exception\CustomerContactNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use OpenApi\Attributes as OA;

class DeleteCustomerContactController extends ApiController
{
    /**
     * Delete a customer contact
     *
     * Delete a customer contact
     */
    #[Rest\Delete(path: '/{id}', name: 'customer_contact_delete', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response'
    )]
    #[OA\Tag(name: 'CustomerContact')]
    public function __invoke(
        string $id,
        DeleteCustomerContact $useCase,
    ): Response {
        try {
            ($useCase)($id);
            $view = View::create(null, Response::HTTP_OK);
        } catch (CustomerContactNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
