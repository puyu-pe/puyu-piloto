<?php

namespace App\Saas\Directory\Infrastructure\Api\Controller;

use App\Saas\Directory\Application\GetAll\GetAllDirectorys;
use App\Saas\Directory\Domain\Entity\Directory;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class GetAllDirectoryController extends ApiController
{
    /**
     * Get all directorys
     *
     * Get all directorys
     */
    #[Rest\Get(path: '', name: 'directory_get_all')]
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
                            property: 'Directorys',
                            title: 'directory',
                            type: 'array',
                            items: new OA\Items(ref: new Model(type: Directory::class))
                        )
                    ],
                    type: 'object',
                )
            ]
        )
    )]
    #[OA\Tag(name: 'Directory')]
    public function __invoke(
        GetAllDirectorys $useCase,
    ): Response {
        $directorys = ($useCase)();

        $view = View::create(
            ['directorys' => $directorys],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['directory']);

        return $this->handleView($view);
    }
}
