<?php

namespace App\Service\User;

use App\Form\Type\User\UserType;
use App\Model\Exception\User\UserNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class EditUser
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly GetUser $getUser,
        private readonly DecoderInterface $decoder
    ) {
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(
        Request $request,
        int $id,
    ): array {
        $customerContact = ($this->getUser)($id);
        $form = $this->formFactory->create(UserType::class, $customerContact);
        $form->submit($this->decoder->decode($request->getContent(), 'json'));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($customerContact);
            $this->entityManager->flush();
            return [$customerContact, null];
        }

        return [null, $form];
    }
}
