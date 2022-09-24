<?php

namespace App\Saas\User\Infrastructure\Api\Controller;

use App\Saas\User\Application\Create\CreateUserDto;
use App\Saas\User\Application\Create\CreateUserUseCase;
use App\Saas\User\Domain\Exception\UserDataException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateUserController extends AbstractFOSRestController
{
    #[Rest\Post(name: 'user_save')]
    public function __invoke(
        CreateUserUseCase $useCase,
        SerializerInterface $serializer,
        Request $request,
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
