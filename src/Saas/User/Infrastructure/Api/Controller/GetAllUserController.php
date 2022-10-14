<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\User\Application\GetAll\GetAllUsers;
use App\Saas\User\Domain\Entity\User;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class GetAllUserController extends AbstractFOSRestController
{
    /**
     * Get all user
     *
     * Get all user
     */
    #[Rest\Get(path: '', name: 'user_get_all')]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(
                    property: 'data',
                    properties: [
                        new OA\Property(
                            property: 'Users',
                            title: 'user',
                            type: 'array',
                            items: new OA\Items(ref: new Model(type: User::class))
                        )
                    ],
                    type: 'object',
                )
            ]
        )
    )]
    #[OA\Tag(name: 'User')]
    public function __invoke(
        GetAllUsers $useCase,
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
