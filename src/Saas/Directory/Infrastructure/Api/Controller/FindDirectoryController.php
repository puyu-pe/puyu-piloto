<?php

namespace App\Saas\Directory\Infrastructure\Api\Controller;

use App\Saas\Directory\Application\Find\FindDirectory;
use App\Saas\Directory\Domain\Entity\Directory;
use App\Saas\Directory\Domain\Exception\DirectoryNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use App\Shared\Domain\ValueObjects\Uuid;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class FindDirectoryController extends ApiController
{
    /**
     * Find a directory
     *
     * Find a directory
     */
    #[Rest\Get(path: '/{id}', name: 'directory_find', requirements: ['id' => Requirement::UUID_V4])]
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
        Uuid $id,
        FindDirectory $useCase,
    ): Response {
        try {
            $directory = ($useCase)($id);

            $view = View::create(
                ['directory' => $directory],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['directory']);
        } catch (DirectoryNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
