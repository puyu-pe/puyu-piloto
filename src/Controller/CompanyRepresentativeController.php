<?php

namespace App\Controller;

use App\Entity\CompanyRepresentative;
use App\Repository\CompanyRepresentativeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CompanyRepresentativeController extends AbstractController
{
    #[Route('/', name: 'company_representative_list', methods: 'GET')]
    public function list(
        CompanyRepresentativeRepository $companyRepresentativeRepository,
        NormalizerInterface             $normalizer,
    ): Response
    {
        $representatives = $companyRepresentativeRepository->findAll();
        $data = $normalizer->normalize($representatives, null, ['groups' => ['default']]);
        return new JsonResponse($data);
    }

    #[Route('/', name: 'company_representative_save', methods: 'POST')]
    public function save(
        Request                $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface     $validator,
        NormalizerInterface    $normalizer,
    ): Response
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
            return new JsonResponse($data);
        }
        $entityManager->persist($companyRepresentative);
        $entityManager->flush();

        return new Response('Added company representative: ' . $companyRepresentative->getId());
    }

    #[Route('/{id}', name: 'company_representative_update', requirements: ['id' => '\d+'], methods: 'PUT')]
    public function update(
        int                             $id,
        Request                         $request,
        CompanyRepresentativeRepository $companyRepresentativeRepository,
        NormalizerInterface             $normalizer,
        ValidatorInterface              $validator,
        EntityManagerInterface          $entityManager
    ): Response
    {
        $data = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);
        $companyRepresentative = $companyRepresentativeRepository->find($id);

        if (!$companyRepresentative) {
            return new Response('Not found company representative, id: ' . $id);
        }

        $companyRepresentative->setName($data->name)
            ->setLastName($data->lastName)
            ->setPhone($data->phone)
            ->setJobTitle($data->jobTitle);

        $errors = $validator->validate($companyRepresentative);

        if (count($errors) > 0) {
            $data = $normalizer->normalize($errors, null, ['groups' => ['default']]);
            return new JsonResponse($data);
        }

        $entityManager->persist($companyRepresentative);
        $entityManager->flush();

        return new Response('Update company representative: ' . $companyRepresentative->getId());
    }

    #[Route('/{id}', name: 'company_representative_delete', requirements: ['id' => '\d+'], methods: 'DELETE')]
    public function delete(
        int                             $id,
        CompanyRepresentativeRepository $companyRepresentativeRepository,
        EntityManagerInterface          $entityManager
    ): Response
    {
        $companyRepresentative = $companyRepresentativeRepository->find($id);

        if (!$companyRepresentative) {
            return new Response('Not found company representative, id: ' . $id);
        }

        $entityManager->remove($companyRepresentative);
        $entityManager->flush();

        return new Response('Delete company representative id: ' . $id);
    }
}