<?php

namespace App\Saas\Directory\Infrastructure\Api\Controller;

use App\Saas\Directory\Application\Create\CreateDirectory;
use App\Saas\Directory\Application\Create\CreateDirectoryDto;
use App\Saas\Directory\Domain\Directory;
use App\Saas\Directory\Domain\Exception\DirectoryDataException;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateDirectoryController extends ApiController
{
    /**
     * Add new directory
     *
     * Add new directory
     */
    #[Rest\Post(name: 'directory_save')]
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
        CreateDirectory $useCase,
        SerializerInterface $serializer,
        Request $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateDirectoryDto::class, 'json');
            $directory = ($useCase)($dto);

            $view = View::create(
                ['directory' => $directory],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['directory']);
        } catch (DirectoryDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
