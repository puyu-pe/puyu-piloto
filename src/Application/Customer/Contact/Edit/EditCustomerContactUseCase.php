<?php

namespace App\Application\Customer\Contact\Edit;

use App\Domain\Entity\CustomerContact;
use App\Domain\Exception\Customer\Contact\CustomerContactDataException;
use App\Domain\Exception\Customer\Contact\CustomerContactNotFound;
use App\Domain\Repository\CustomerContactRepository;
use App\Domain\Service\Customer\Contact\FindCustomerContact;
use App\Domain\Shared\Validator;

class EditCustomerContactUseCase
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
     * @throws CustomerContactDataException
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
