<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Model\Exception\User\UserNotFound;
use App\Repository\UserRepository;
use App\Service\User\DeleteUser;
use App\Service\User\EditUser;
use App\Service\User\GetUser;
use App\Service\User\SaveUser;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/user', name: 'user_list')]
    #[Rest\View(serializerGroups: ['user'])]
    public function getAction(
        UserRepository $userRepository,
    ): array {
        return $userRepository->findAll();
    }

    #[Rest\Get(path: '/user/{id}', name: 'user_single')]
    #[Rest\View(serializerGroups: ['user'])]
    public function getSingleAction(
        int $id,
        GetUser $getUser,
    ): User|View {
        try {
            $user = ($getUser)($id);
            return View::create($user, Response::HTTP_ACCEPTED);
        } catch (UserNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }


    #[Rest\Post(path: '/user', name: 'user_save')]
    public function postAction(
        SaveUser $saveUser,
        Request $request,
    ): View {
        [$user, $error] = ($saveUser)($request);
        $statusCode = $user ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $user ?? $error;
        return View::create($data, $statusCode);
    }


    #[Rest\Put(path: '/user/{id}', name: 'user_update', requirements: ['id' => '\d+'])]
    public function editAction(
        int $id,
        Request $request,
        EditUser $editUser,
    ): View {
        try {
            [$user, $error] = ($editUser)($request, $id);
            $statusCode = $user ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
            $data = $user ?? $error;
            return View::create($data, $statusCode);
        } catch (UserNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Rest\Delete(path: '/user/{id}', name: 'user_delete', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int $id,
        DeleteUser $deleteUser
    ): View {
        try {
            ($deleteUser)($id);
        } catch (UserNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
