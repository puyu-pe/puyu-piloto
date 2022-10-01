<?php

namespace App\Saas\CustomerContact\Application\Edit;

use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Exception\CustomerContactDataException;
use App\Saas\CustomerContact\Domain\Exception\CustomerContactNotFound;
use App\Saas\CustomerContact\Domain\Repository\CustomerContactRepository;
use App\Saas\CustomerContact\Domain\Service\FindCustomerContact;
use App\Saas\Shared\Domain\Validation\Validator;

class EditCustomerContact
{
    private FindCustomerContact $finder;

    public function __construct(
        private readonly CustomerContactRepository $repository,
        private readonly Validator $validator,
    ) {
        $this->finder = new FindCustomerContact($repository);
    }

    /**
     * @throws CustomerContactDataException
     * @throws CustomerContactNotFound
     */
    public function __invoke(
        string $id,
        EditCustomerContactDto $dto,
    ): CustomerContact {
        $this->guard($dto);
        $customerContact = ($this->finder)($id);

        $customerContact
            ->setName($dto->getName())
            ->setLastName($dto->getLastName())
            ->setPhone($dto->getPhone())
            ->setjobTitle($dto->getjobTitle());

        $this->repository->save($customerContact);

        return $customerContact;
    }

    /**
     * @throws \App\Saas\CustomerContact\Domain\Exception\CustomerContactDataException
     */
    public function guard(EditCustomerContactDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            $error = $errors[0];
            throw new CustomerContactDataException($error->getField(), $error->getMessage());
        }
    }
}
