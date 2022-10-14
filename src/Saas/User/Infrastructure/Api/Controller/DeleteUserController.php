<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use App\Saas\User\Application\Delete\DeleteUser;
use App\Saas\User\Domain\Exception\UserNotFound;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteUserController extends ApiController
{
    /**
     * Delete a user
     *
     * Delete a user
     */
    #[Rest\Delete(path: '/{id}', name: 'user_delete', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response'
    )]
    #[OA\Tag(name: 'User')]
    public function __invoke(
        string     $id,
        DeleteUser $useCase,
    ): Response {
        try {
            ($useCase)($id);
            $view = View::create(null, Response::HTTP_OK);
        } catch (UserNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
