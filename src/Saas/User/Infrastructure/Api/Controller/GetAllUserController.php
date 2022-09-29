<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\User\Application\GetAll\GetAllUsersUseCase;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class GetAllUserController extends AbstractFOSRestController
{
    #[Rest\Get(path: '', name: 'user_get_all')]
    public function __invoke(
        GetAllUsersUseCase $useCase,
    ): Response {
        $user = ($useCase)();

        $view = View::create(
            ['user' => $user],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['user']);

        return $this->handleView($view);
    }
}
