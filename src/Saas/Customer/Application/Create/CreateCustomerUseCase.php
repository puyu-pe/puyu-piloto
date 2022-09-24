<?php

namespace App\Saas\Customer\Application\Create;

use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Customer\Domain\Exception\CustomerDataException;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Shared\Domain\Validation\Validator;

class CreateCustomerUseCase
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly Validator $validator,
    ) {
    }

    /**
     * @throws CustomerDataException
     */
    public function __invoke(
        CreateCustomerDto $dto
    ): Customer {
        $this->guard($dto);

        $customer = Customer::create(
            $dto->getDocument_number(),
            $dto->getName(),
            $dto->getAddress(),
            $dto->getEmail(),
            $dto->getPhone(),
        );

        $this->customerRepository->save($customer);
        return $customer;
    }

    /**
     * @throws CustomerDataException
     */
    public function guard(CreateCustomerDto $customer): void
    {
        $errors = $this->validator->validate($customer);
        if (count($errors)) {
            $error = $errors[0];
            throw new CustomerDataException($error->getField(), $error->getMessage());
        }
    }
}
