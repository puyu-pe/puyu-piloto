<?php

namespace App\Service\Customer\Contact;

use App\Form\Type\Customer\CustomerContactType;
use App\Model\Exception\Customer\CustomerContactNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class EditCustomerContact
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly GetCustomerContactById $getCustomerContact,
        private readonly DecoderInterface $decoder
    ) {
    }

    /**
     * @throws CustomerContactNotFound
     */
    public function __invoke(
        Request $request,
        int $id,
    ): array {
        $customerContact = ($this->getCustomerContact)($id);
        $form = $this->formFactory->create(CustomerContactType::class, $customerContact);
        $form->submit($this->decoder->decode($request->getContent(), 'json'));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($customerContact);
            $this->entityManager->flush();
            return [$customerContact, null];
        }

        return [null, $form];
    }
}
