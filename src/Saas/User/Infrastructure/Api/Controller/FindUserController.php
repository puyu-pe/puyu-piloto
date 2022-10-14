<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use App\Saas\User\Domain\Entity\User;
use App\Saas\User\Application\Find\FindUser;
use App\Saas\User\Domain\Exception\UserNotFound;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class FindUserController extends ApiController
{
    /**
     * Find a user
     *
     * Find a user
     */
    #[Rest\Get(path: '/{id}', name: 'user_find', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(property: 'data', ref: new Model(type: User::class))
            ]
        )
    )]
    #[OA\Tag(name: 'User')]
    public function __invoke(
        Uuid     $id,
        FindUser $useCase,
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
