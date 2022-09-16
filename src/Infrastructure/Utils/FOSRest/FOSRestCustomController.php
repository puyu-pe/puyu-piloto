<?php

namespace App\Infrastructure\Utils\FOSRest;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class FOSRestCustomController extends AbstractFOSRestController
{
    public function HttpResponse(mixed $data, int $http_code): Response
    {
        return $this->handleView(View::create($data, $http_code));
    }
}