<?php

namespace App\Service\Customer\Contact;

use App\Entity\CustomerContact;
use App\Model\Exception\Customer\CustomerContactDataException;
use App\Model\Exception\Customer\CustomerContactNotFound;
use App\Service\Customer\Contact\Dto\CustomerContactDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateCustomerContact
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
    ) {
    }

    /**
     * @throws CustomerContactDataException
     */
    public function __invoke(
        CustomerContactDto $customerContactDto,
    ): CustomerContact {
        $customerContact = $customerContactDto->toCustomerContact();

        $errors = $this->validator->validate($customerContact);
        if (count($errors)) {
            CustomerContactDataException::throwException((string)$errors);
        }

        $this->entityManager->persist($customerContact);
        $this->entityManager->flush();

        return $customerContact;
    }
}
