<?php

namespace App\Application\Customer\Contact\Create;

use App\Domain\Entity\CustomerContact;
use App\Domain\Exception\Customer\Contact\CustomerContactDataException;
use App\Domain\Repository\CustomerContactRepository;
use App\Domain\Shared\Validator;

class CreateCustomerContactUseCase
{
    public function __construct(
        private readonly CustomerContactRepository $customerContactRepository,
        private readonly Validator $validator,
    ) {
    }

    /**
     * @throws CustomerContactDataException
     */
    public function __invoke(
        CreateCustomerContactDto $dto
    ): CustomerContact {
        $this->guard($dto);

        $customerContact = CustomerContact::create(
            $dto->getName(),
            $dto->getLastName(),
            $dto->getPhone(),
            $dto->getJobTitle(),
        );

        $this->customerContactRepository->save($customerContact);
        return $customerContact;
    }

    /**
     * @throws CustomerContactDataException
     */
    public function guard(CreateCustomerContactDto $customerContact): void
    {
        $errors = $this->validator->validate($customerContact);
        if (count($errors)) {
            $error = $errors[0];
            throw new CustomerContactDataException($error->getField(), $error->getMessage());
        }
    }
}
