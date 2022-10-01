<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\User\Application\Delete\DeleteUser;
use App\Saas\User\Domain\Exception\UserNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteUserController extends AbstractFOSRestController
{
    #[Rest\Delete(path: '/{id}', name: 'user_delete', requirements: ['id' => Requirement::UUID_V4])]
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
