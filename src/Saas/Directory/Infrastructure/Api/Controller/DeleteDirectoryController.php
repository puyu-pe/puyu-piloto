<?php

namespace App\Saas\Directory\Infrastructure\Api\Controller;

use App\Saas\Directory\Application\Delete\DeleteDirectory;
use App\Saas\Directory\Domain\Exception\DirectoryNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteDirectoryController extends ApiController
{
    /**
     * Delete a directory
     *
     * Delete a directory
     */
    #[Rest\Delete(path: '/{id}', name: 'directory_delete', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response'
    )]
    #[OA\Tag(name: 'Directory')]
    public function __invoke(
        string $id,
        DeleteDirectory $useCase,
    ): Response {
        try {
            ($useCase)($id);
            $view = View::create(null, Response::HTTP_OK);
        } catch (DirectoryNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
