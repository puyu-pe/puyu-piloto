<?php

namespace App\Saas\Project\Infrastructure\Api\Controller;

use App\Saas\Project\Application\Create\CreateProjectDto;
use App\Saas\Project\Application\Edit\EditProject;
use App\Saas\Project\Application\Edit\EditProjectDto;
use App\Saas\Project\Domain\Entity\Project;
use App\Saas\Project\Domain\Exception\ProjectDataException;
use App\Saas\Project\Domain\Exception\ProjectNotFound;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class EditProjectController extends ApiController
{
    /**
     * Edit a project
     *
     * Edit a project
     */
    #[Rest\Put(path: '/{id}', name: 'project_update', requirements: ['id' => Requirement::UUID_V4])]
    #[OA\RequestBody(content: new Model(type: CreateProjectDto::class))]
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
        string $id,
        Request $request,
        EditProject $useCase,
        SerializerInterface $serializer,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), EditProjectDto::class, 'json');
            $project = ($useCase)($id, $dto);

            $view = View::create(
                ['project' => $project],
                Response::HTTP_ACCEPTED
            );
            $view->getContext()->setGroups(['project']);
        } catch (ProjectNotFound|ProjectDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
