<?php

namespace App\Controller\Api;

use App\Entity\CompanyRepresentative;
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
        ValidatorInterface     $validator,
        NormalizerInterface    $normalizer,
    ): View
    {
        $data = json_decode($request->getContent());
        $companyRepresentative = new CompanyRepresentative();
        $companyRepresentative->setName($data->name)
            ->setLastName($data->lastName)
            ->setPhone($data->phone)
            ->setJobTitle($data->jobTitle);

        $errors = $validator->validate($companyRepresentative);

        if (count($errors) > 0) {
            $data = $normalizer->normalize($errors, null, ['groups' => ['default']]);
            return View::create($data, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($companyRepresentative);
        $entityManager->flush();

        return View::create('Added company representative: ' . $companyRepresentative->getId(), Response::HTTP_CREATED);
    }


    #[Rest\Put(path: '/api/company_representative/{id}', name: 'company_representative_update', requirements: ['id' => '\d+'])]
    public function editAcion(
        int                             $id,
        Request                         $request,
        CompanyRepresentativeRepository $companyRepresentativeRepository,
        NormalizerInterface             $normalizer,
        ValidatorInterface              $validator,
        EntityManagerInterface          $entityManager
    ): View
    {
        $data = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
        $companyRepresentative = $companyRepresentativeRepository->find($id);

        if (!$companyRepresentative) {
            return View::create('Not found company representative, id: ' . $id, Response::HTTP_BAD_REQUEST);
        }

        $companyRepresentative->setName($data->name)
            ->setLastName($data->lastName)
            ->setPhone($data->phone)
            ->setJobTitle($data->jobTitle);

        $errors = $validator->validate($companyRepresentative);

        if (count($errors) > 0) {
            $data = $normalizer->normalize($errors, null, ['groups' => ['default']]);
            return View::create($data, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($companyRepresentative);
        $entityManager->flush();

        return View::create('Update company representative: ' . $companyRepresentative->getId(), Response::HTTP_ACCEPTED);
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