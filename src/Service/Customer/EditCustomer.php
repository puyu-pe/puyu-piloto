<?php

namespace App\Service\Customer;

use App\Form\Type\Customer\CustomerType;
use App\Model\Exception\Customer\CustomerNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class EditCustomer
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly GetCustomer $getCustomer,
        private readonly DecoderInterface $decoder
    ) {
    }

    /**
     * @throws CustomerNotFound
     */
    public function __invoke(
        Request $request,
        int $id,
    ): array {
        $customer = ($this->getCustomer)($id);
        $form = $this->formFactory->create(CustomerType::class, $customer);
        $form->submit($this->decoder->decode($request->getContent(), 'json'));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            return [$customer, null];
        }

        return [null, $form];
    }
}
