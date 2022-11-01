<?php

namespace App\Saas\Directory\Infrastructure\Api\Controller;

use App\Saas\Directory\Application\GetAll\GetAllDirectory;
use App\Saas\Directory\Domain\Directory;
use App\Saas\Shared\Infrastructure\Api\Controller\ApiController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class GetAllDirectoryController extends ApiController
{
    /**
     * Get all directory
     *
     * Get all directory
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
                            property: 'directories',
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
        GetAllDirectory $useCase,
    ): Response {
        $directories = ($useCase)();

        $view = View::create(
            ['directories' => $directories],
            Response::HTTP_OK
        );
        $view->getContext()->setGroups(['directory']);

        return $this->handleView($view);
    }
}
