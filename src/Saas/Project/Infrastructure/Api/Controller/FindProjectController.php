<?php

namespace App\Saas\Project\Infrastructure\Api\Controller;

use App\Saas\Project\Application\Find\FindProject;
use App\Saas\Project\Domain\Exception\ProjectNotFound;
use App\Saas\Project\Domain\Project;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use App\Shared\Domain\ValueObjects\Uuid;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;

class FindProjectController extends ApiController
{
    /**
     * Find a project
     *
     * Find a project
     */
    #[Rest\Get(path: '/{id}', name: 'project_find', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(property: 'data', ref: new Model(type: Project::class))
            ]
        )
    )]
    #[OA\Tag(name: 'Project')]
    public function __invoke(
        Uuid $id,
        FindProject $useCase,
    ): Response {
        try {
            $project = ($useCase)($id);

            $view = View::create(
                ['project' => $project],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['project']);
        } catch (ProjectNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
