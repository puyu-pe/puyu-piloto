<?php

namespace App\Controller\Api;

use App\Entity\CompanyRepresentative;
use App\Model\Exception\Company\CompanyRepresentativeNotFound;
use App\Repository\CompanyRepresentativeRepository;
use App\Service\Company\Representative\DeleteCompanyRepresentative;
use App\Service\Company\Representative\EditCompanyRepresentative;
use App\Service\Company\Representative\GetCompanyRepresentative;
use App\Service\Company\Representative\SaveCompanyRepresentative;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyRepresentativeController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/api/company_representative', name: 'company_representative_list')]
    #[Rest\View(serializerGroups: ['company_representative'])]
    public function getAction(
        CompanyRepresentativeRepository $companyRepresentativeRepository,
    ): array
    {
        return $companyRepresentativeRepository->findAll();
    }

    #[Rest\Get(path: '/api/company_representative/{id}', name: 'company_representative_single')]
    #[Rest\View(serializerGroups: ['company_representative'])]
    public function getSingleAction(
        int                      $id,
        GetCompanyRepresentative $getCompanyRepresentative,
    ): CompanyRepresentative|View
    {
        try {
            $companyRepresentative = ($getCompanyRepresentative)($id);
        } catch (CompanyRepresentativeNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return $companyRepresentative;
    }


    #[Rest\Post(path: '/api/company_representative', name: 'company_representative_save')]
    public function postAction(
        SaveCompanyRepresentative $saveCompanyRepresentative,
        Request                   $request,
    ): View
    {

        [$companyRepresentative, $error] = ($saveCompanyRepresentative)($request);
        $statusCode = $companyRepresentative ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $companyRepresentative ?? $error;
        return View::create($data, $statusCode);
    }


    #[Rest\Put(path: '/api/company_representative/{id}', name: 'company_representative_update', requirements: ['id' => '\d+'])]
    public function editAction(
        int                       $id,
        Request                   $request,
        EditCompanyRepresentative $EditCompanyRepresentative,
    ): View
    {
        try {
            [$companyRepresentative, $error] = ($EditCompanyRepresentative)($request, $id);
            $statusCode = $companyRepresentative ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
            $data = $companyRepresentative ?? $error;
            return View::create($data, $statusCode);
        } catch (CompanyRepresentativeNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Rest\Delete(path: '/api/company_representative/{id}', name: 'company_representative_delete', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int                         $id,
        DeleteCompanyRepresentative $deleteCompanyRepresentative
    ): View
    {
        try {
            ($deleteCompanyRepresentative)($id);
        } catch (CompanyRepresentativeNotFound $e) {
            return View::create($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}