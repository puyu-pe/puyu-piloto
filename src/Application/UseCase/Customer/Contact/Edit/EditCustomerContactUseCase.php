<?php

namespace App\Application\UseCase\Customer\Contact\Edit;

use App\Application\Exception\Customer\CustomerContactDataException;
use App\Application\Exception\Customer\CustomerContactNotFound;
use App\Domain\Customer\Contact\FindCustomerContact;
use App\Domain\Entity\CustomerContact;
use App\Domain\Repository\CustomerContactRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EditCustomerContactUseCase
{
    private FindCustomerContact $finder;

    public function __construct(
        private readonly CustomerContactRepository $repository,
        private readonly ValidatorInterface $validator,
    ) {
        $this->finder = new FindCustomerContact($repository);
    }

    /**
     * @throws CustomerContactNotFound
     * @throws CustomerContactDataException
     */
    public function __invoke(
        EditCustomerContactCommand $command,
    ): CustomerContact {
        $customerContact = CustomerContact::create(
            $command->getName(),
            $command->getLastName(),
            $command->getJobTitle(),
            $command->getPhone(),
        );

        $this->guard($customerContact);
        $old = ($this->finder)($command->getId());

        $customerContact->setName($old->getName());
        $customerContact->setLastName($old->getLastName());
        $customerContact->setPhone($old->getPhone());
        $customerContact->setjobTitle($old->getjobTitle());

        $this->repository->save($customerContact);

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
