<?php

namespace App\Saas\Project\Infrastructure\Api\Controller;

use App\Saas\Project\Application\GetAll\GetAllProjects;
use App\Saas\Project\Domain\Entity\Project;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class GetAllProjectController extends ApiController
{
    /**
     * Get all projects
     *
     * Get all projects
     */
    #[Rest\Get(path: '', name: 'project_get_all')]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', example: 'success'),
                new OA\Property(
                    property: 'data',
                    properties: [
                        new OA\Property(
                            property: 'Projects',
                            title: 'project',
                            type: 'array',
                            items: new OA\Items(ref: new Model(type: Project::class))
                        )
                    ],
                    type: 'object',
                )
            ]
        )
    )]
    #[OA\Tag(name: 'Project')]
    public function __invoke(
        GetAllProjects $useCase,
    ): Response {
        $projects = ($useCase)();

        $view = View::create(
            ['projects' => $projects],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['project']);

        return $this->handleView($view);
    }
}
