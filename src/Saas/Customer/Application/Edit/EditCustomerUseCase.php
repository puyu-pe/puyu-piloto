<?php

namespace App\Saas\Customer\Application\Edit;

use App\Saas\Customer\Domain\Entity\Customer;
use App\Saas\Customer\Domain\Exception\CustomerDataException;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Service\FindCustomer;
use App\Saas\Shared\Domain\Validation\Validator;

class EditCustomerUseCase
{
    private FindCustomer $finder;

    public function __construct(
        private readonly CustomerRepository $repository,
        private readonly Validator $validator,
    ) {
        $this->finder = new FindCustomer($repository);
    }

    /**
     * @throws CustomerDataException
     * @throws CustomerNotFound
     */
    public function __invoke(
        string $id,
        EditCustomerDto $dto,
    ): Customer {
        $this->guard($dto);
        $customer = ($this->finder)($id);

        $customer
            ->setDocumentNumber($dto->getDocumentNumber())
            ->setName($dto->getName())
            ->setAddress($dto->getAddress())
            ->setEmail($dto->getEmail())
            ->setPhone($dto->getPhone());

        $this->repository->save($customer);

        return $customer;
    }

    /**
     * @throws \App\Saas\Customer\Domain\Exception\CustomerDataException
     */
    public function guard(EditCustomerDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            $error = $errors[0];
            throw new CustomerDataException($error->getField(), $error->getMessage());
        }
    }
}
