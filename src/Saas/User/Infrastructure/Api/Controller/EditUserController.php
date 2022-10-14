<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\User\Application\Create\CreateUserDto;
use App\Saas\User\Domain\Entity\User;
use App\Saas\User\Application\Edit\EditUser;
use App\Saas\User\Application\Edit\EditUserDto;
use App\Saas\User\Domain\Exception\UserNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class EditUserController extends AbstractFOSRestController
{
    /**
     * Edit a user
     *
     * Edit a user
     */
    #[Rest\Put(path: '/{id}', name: 'user_update', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\RequestBody(content: new Model(type: CreateUserDto::class))]
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
        string              $id,
        Request             $request,
        EditUser            $useCase,
        SerializerInterface $serializer,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), EditUserDto::class, 'json');
            $user = ($useCase)($id, $dto);

            $view = View::create(
                ['user' => $user],
                Response::HTTP_ACCEPTED
            );
            $view->getContext()->setGroups(['user']);
        } catch (UserNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
