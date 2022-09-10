<?php

namespace App\Service\Company\Representative;

use App\Form\Type\CompanyRepresentativeType;
use App\Model\Exception\Company\CompanyRepresentativeNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class EditCompanyRepresentative
{
    public function __construct(
        private readonly EntityManagerInterface   $entityManager,
        private readonly FormFactoryInterface     $formFactory,
        private readonly GetCompanyRepresentative $getCompanyRepresentative,
        private readonly DecoderInterface $decoder
    )
    {
    }

    /**
     * @throws CompanyRepresentativeNotFound
     */
    public function __invoke(
        Request $request,
        int     $id,
    ): array
    {
        $companyRepresentative = ($this->getCompanyRepresentative)($id);
        $form = $this->formFactory->create(CompanyRepresentativeType::class, $companyRepresentative);
        $form->submit($this->decoder->decode($request->getContent(), 'json'));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($companyRepresentative);
            $this->entityManager->flush();
            return [$companyRepresentative, null];
        }

        return [null, $form];
    }
}