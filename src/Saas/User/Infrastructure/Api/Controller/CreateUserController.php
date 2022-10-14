<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\User\Application\Create\CreateUserDto;
use App\Saas\User\Domain\Entity\User;
use App\Saas\User\Application\Create\CreateUser;
use App\Saas\User\Domain\Exception\UserDataException;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateUserController extends ApiController
{
     /**
     * Add new user
     *
     * Add new user
     */
    #[Rest\Post(name: 'user_save')]
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
        CreateUser          $useCase,
        SerializerInterface $serializer,
        Request             $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateUserDto::class, 'json');
            $user = ($useCase)($dto);

            $view = View::create(
                ['user' => $user],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['user']);
        } catch (UserDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
