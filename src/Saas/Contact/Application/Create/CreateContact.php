<?php

namespace App\Saas\Contact\Application\Create;

use App\Saas\Contact\Domain\Contact;
use App\Saas\Contact\Domain\Exception\ContactDataException;
use App\Saas\Contact\Domain\Repository\ContactRepository;
use App\Saas\Shared\Domain\Validation\Validator;

class CreateContact
{
    public function __construct(
        private readonly ContactRepository $contactRepository,
        private readonly Validator         $validator,
    ) {
    }

    /**
     * @throws ContactDataException
     */
    public function __invoke(
        CreateContactDto $dto
    ): Contact {
        $this->guard($dto);

        $contact = Contact::create(
            $dto->getName(),
            $dto->getLastName(),
            $dto->getPhone(),
            $dto->getJobTitle(),
        );

        $this->contactRepository->save($contact);
        return $contact;
    }

    /**
     * @throws ContactDataException
     */
    public function guard(CreateContactDto $contact): void
    {
        $errors = $this->validator->validate($contact);
        if (count($errors)) {
            $error = $errors[0];
            throw new ContactDataException($error->getField(), $error->getMessage());
        }
    }
}
