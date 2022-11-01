<?php

namespace App\Saas\Directory\Application\Edit;

use App\Saas\Contact\Domain\Exception\ContactNotFound;
use App\Saas\Contact\Domain\Repository\ContactRepository;
use App\Saas\Contact\Domain\Service\FindContact as DomainFindContact;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Service\FindCustomer as DomainFindCustomer;
use App\Saas\Directory\Domain\Directory;
use App\Saas\Directory\Domain\Exception\DirectoryDataException;
use App\Saas\Directory\Domain\Exception\DirectoryNotFound;
use App\Saas\Directory\Domain\Repository\DirectoryRepository;
use App\Saas\Directory\Domain\Service\FindDirectory;
use App\Saas\Shared\Domain\Validation\Validator;

class EditDirectory
{
    private DomainFindCustomer $customerFinder;
    private DomainFindContact $contactFinder;
    private FindDirectory $finder;

    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly ContactRepository $contactRepository,
        private readonly DirectoryRepository $repository,
        private readonly Validator $validator,
    ) {
        $this->customerFinder = new DomainFindCustomer($this->customerRepository);
        $this->contactFinder = new DomainFindContact($this->contactRepository);
        $this->finder = new FindDirectory($repository);
    }

    /**
     * @throws DirectoryDataException
     * @throws DirectoryNotFound
     * @throws CustomerNotFound
     * @throws ContactNotFound
     */
    public function __invoke(
        string $id,
        EditDirectoryDto $dto,
    ): Directory {
        $this->guard($dto);
        $directory = ($this->finder)($id);

        $customer = ($this->customerFinder)($dto->getCustomerId());
        $contact = ($this->contactFinder)($dto->getContactId());

        $directory
            ->setCustomer($customer)
            ->setContact($contact);

        $this->repository->save($directory);

        return $directory;
    }

    /**
     * @throws DirectoryDataException
     */
    public function guard(EditDirectoryDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            $error = $errors[0];
            throw new DirectoryDataException($error->getField(), $error->getMessage());
        }
    }
}
