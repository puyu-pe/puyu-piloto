<?php

namespace App\Application\UseCase\Customer\Contact\Create;

use App\Application\Exception\Customer\CustomerContactDataException;
use App\Domain\Entity\CustomerContact;
use App\Domain\Repository\CustomerContactRepository;
use App\Domain\Validator\ValidatorInterface;

class CreateCustomerContactUseCase
{
    public function __construct(
        private readonly CustomerContactRepository $customerContactRepository,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function __invoke(
        ?string $name,
        ?string $lastName,
        ?string $phone,
        ?string $jobTitle,
    ): CustomerContact {
        $customerContact = CustomerContact::create($name, $lastName, $jobTitle, $phone);
        $this->guard($customerContact);
        $this->customerContactRepository->save($customerContact);
        return $customerContact;
    }

    public function guard(CustomerContact $customerContact): void
    {
        $errors = $this->validator->validate($customerContact);
        if (count($errors)) {
            CustomerContactDataException::throwException((string)$errors);
        }
    }
}
