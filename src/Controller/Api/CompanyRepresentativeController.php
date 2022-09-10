<?php

namespace App\Controller\Api;

use App\Entity\CompanyRepresentative;
use App\Form\Model\Product\ProductDto;
use App\Form\Type\CompanyRepresentativeType;
use App\Form\Type\Product\ProductType;
use App\Repository\CompanyRepresentativeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CompanyRepresentativeController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/api/company_representative', name: 'company_representative_list')]
    #[Rest\View(serializerGroups: ['company_representative'])]
    public function getAction(
        CompanyRepresentativeRepository $companyRepresentativeRepository,
    )
    {
        return $companyRepresentativeRepository->findAll();
    }

    #[Rest\Post(path: '/api/company_representative', name: 'company_representative_save')]
    public function postAction(
        Request                $request,
        EntityManagerInterface $entityManager,
    ): View
    {
        $companyRepresentative = new CompanyRepresentative();
        $form = $this->createForm(CompanyRepresentativeType::class, $companyRepresentative);
        $form->handleRequest($request);

        dd($form->isSubmitted());
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($companyRepresentative);
            $entityManager->flush();
            return View::create('Added company representative: ' . $companyRepresentative->getId(), Response::HTTP_CREATED);
        }

        return View::create($form, Response::HTTP_BAD_REQUEST);
    }


    #[Rest\Put(path: '/api/company_representative/{id}', name: 'company_representative_update', requirements: ['id' => '\d+'])]
    public function editAcion(
        int                             $id,
        Request                         $request,
        CompanyRepresentativeRepository $companyRepresentativeRepository,
        EntityManagerInterface          $entityManager
    ): View
    {
        $companyRepresentative = $companyRepresentativeRepository->find($id);
        if (!$companyRepresentative) {
            return View::create('Not found company representative, id: ' . $id, Response::HTTP_BAD_REQUEST);
        }

        $form = $this->createForm(CompanyRepresentativeType::class, $companyRepresentative);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($companyRepresentative);
            $entityManager->flush();
            return View::create('Updated company representative: ' . $companyRepresentative->getId(), Response::HTTP_CREATED);
        }

        return View::create($form, Response::HTTP_BAD_REQUEST);
    }

    #[Rest\Delete(path: '/api/company_representative/{id}', name: 'company_representative_delete', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int                             $id,
        CompanyRepresentativeRepository $companyRepresentativeRepository,
        EntityManagerInterface          $entityManager
    ): View
    {
        $companyRepresentative = $companyRepresentativeRepository->find($id);

        if (!$companyRepresentative) {
            return View::create('Not found company representative, id: ' . $id, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->remove($companyRepresentative);
        $entityManager->flush();

        return View::create('Delete company representative id: ' . $id, Response::HTTP_NO_CONTENT);
    }
}