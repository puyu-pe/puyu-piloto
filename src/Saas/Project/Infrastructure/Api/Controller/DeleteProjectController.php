<?php

namespace App\Saas\Project\Infrastructure\Api\Controller;

use App\Saas\Project\Application\Delete\DeleteProject;
use App\Saas\Project\Domain\Exception\ProjectNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteProjectController extends ApiController
{
    /**
     * Delete a project
     *
     * Delete a project
     */
    #[Rest\Delete(path: '/{id}', name: 'project_delete', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response'
    )]
    #[OA\Tag(name: 'Project')]
    public function __invoke(
        string $id,
        DeleteProject $useCase,
    ): Response {
        try {
            ($useCase)($id);
            $view = View::create(null, Response::HTTP_OK);
        } catch (ProjectNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
