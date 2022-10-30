<?php

namespace App\Saas\Directory\Infrastructure\Api\Controller;

use App\Saas\Directory\Application\Create\CreateDirectoryDto;
use App\Saas\Directory\Application\Edit\EditDirectory;
use App\Saas\Directory\Application\Edit\EditDirectoryDto;
use App\Saas\Directory\Domain\Entity\Directory;
use App\Saas\Directory\Domain\Exception\DirectoryDataException;
use App\Saas\Directory\Domain\Exception\DirectoryNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class EditDirectoryController extends ApiController
{
    /**
     * Edit a directory
     *
     * Edit a directory
     */
    #[Rest\Put(path: '/{id}', name: 'directory_update', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\RequestBody(content: new Model(type: CreateDirectoryDto::class))]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(property: 'data', ref: new Model(type: Directory::class))
            ]
        )
    )]
    #[OA\Tag(name: 'Directory')]
    public function __invoke(
        string $id,
        Request $request,
        EditDirectory $useCase,
        SerializerInterface $serializer,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), EditDirectoryDto::class, 'json');
            $directory = ($useCase)($id, $dto);

            $view = View::create(
                ['directory' => $directory],
                Response::HTTP_ACCEPTED
            );
            $view->getContext()->setGroups(['directory']);
        } catch (DirectoryNotFound|DirectoryDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
