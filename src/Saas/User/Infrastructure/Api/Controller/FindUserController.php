<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\User\Application\Find\FindUserUseCase;
use App\Saas\User\Domain\Exception\UserNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class FindUserController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/{id}', name: 'user_find', requirements: ['id' => Requirement::UUID_V4])]
    public function __invoke(
        Uuid $id,
        FindUserUseCase $useCase,
    ): Response {
        try {
            $user = ($useCase)($id);

            $view = View::create(
                ['user' => $user],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['user']);
        } catch (UserNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
