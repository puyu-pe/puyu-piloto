<?php

namespace App\Saas\Project\Infrastructure\Api\Controller;

use App\Saas\Project\Application\Create\CreateProject;
use App\Saas\Project\Application\Create\CreateProjectDto;
use App\Saas\Project\Domain\Exception\ProjectDataException;
use App\Saas\Project\Domain\Project;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateProjectController extends ApiController
{
    /**
     * Add new project
     *
     * Add new project
     */
    #[Rest\Post(name: 'project_save')]
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
        CreateProject $useCase,
        SerializerInterface $serializer,
        Request $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateProjectDto::class, 'json');
            $project = ($useCase)($dto);

            $view = View::create(
                ['project' => $project],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['project']);
        } catch (ProjectDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
