<?php

namespace App\Saas\Contact\Application\Edit;

use App\Saas\Contact\Domain\Entity\Contact;
use App\Saas\Contact\Domain\Exception\ContactDataException;
use App\Saas\Contact\Domain\Exception\ContactNotFound;
use App\Saas\Contact\Domain\Repository\ContactRepository;
use App\Saas\Contact\Domain\Service\FindContact;
use App\Saas\Shared\Domain\Validation\Validator;

class EditContact
{
    private FindContact $finder;

    public function __construct(
        private readonly ContactRepository $repository,
        private readonly Validator         $validator,
    ) {
        $this->finder = new FindContact($repository);
    }

    /**
     * @throws ContactDataException
     * @throws ContactNotFound
     */
    public function __invoke(
        string         $id,
        EditContactDto $dto,
    ): Contact {
        $this->guard($dto);
        $contact = ($this->finder)($id);

        $contact
            ->setName($dto->getName())
            ->setLastName($dto->getLastName())
            ->setPhone($dto->getPhone())
            ->setjobTitle($dto->getjobTitle());

        $this->repository->save($contact);

        return $contact;
    }

    /**
     * @throws \App\Saas\Contact\Domain\Exception\ContactDataException
     */
    public function guard(EditContactDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            $error = $errors[0];
            throw new ContactDataException($error->getField(), $error->getMessage());
        }
    }
}
