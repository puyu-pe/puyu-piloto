<?php

namespace App\Saas\Directory\Application\Create;

use App\Saas\Contact\Domain\Exception\ContactNotFound;
use App\Saas\Contact\Domain\Repository\ContactRepository;
use App\Saas\Contact\Domain\Service\FindContact as DomainFindContact;
use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Service\FindCustomer as DomainFindCustomer;
use App\Saas\Directory\Domain\Entity\Directory;
use App\Saas\Directory\Domain\Exception\DirectoryDataException;
use App\Saas\Directory\Domain\Repository\DirectoryRepository;
use App\Saas\Shared\Domain\Validation\Validator;

class CreateDirectory
{
    private DomainFindCustomer $customerFinder;
    private DomainFindContact $contactFinder;

    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly ContactRepository $contactRepository,
        private readonly DirectoryRepository $directoryRepository,
        private readonly Validator $validator,
    ) {
        $this->customerFinder = new DomainFindCustomer($this->customerRepository);
        $this->contactFinder = new DomainFindContact($this->contactRepository);
    }

    /**
     * @throws DirectoryDataException
     * @throws CustomerNotFound
     * @throws ContactNotFound
     */
    public function __invoke(
        CreateDirectoryDto $dto
    ): Directory {
        $this->guard($dto);

        $customer = ($this->customerFinder)($dto->getCustomerId());
        $contact = ($this->contactFinder)($dto->getContactId());

        $directory = Directory::create(
            $customer,
            $contact
        );

        $this->directoryRepository->save($directory);
        return $directory;
    }

    /**
     * @throws DirectoryDataException
     */
    public function guard(CreateDirectoryDto $directory): void
    {
        $errors = $this->validator->validate($directory);
        if (count($errors)) {
            $error = $errors[0];
            throw new DirectoryDataException($error->getField(), $error->getMessage());
        }
    }
}
