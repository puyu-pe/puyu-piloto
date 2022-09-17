<?php

namespace App\Service\User;

use App\Entity\User;
use App\Model\Exception\User\UserNotFound;
use App\Repository\UserRepository;

class GetUser
{
    public function __construct(
        private readonly UserRepository $customerContactRepository,
    ) {
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(int $id): User
    {
        $customerContact = $this->customerContactRepository->find($id);

        if (!$customerContact) {
            UserNotFound::throwException();
        }
        return $customerContact;
    }
}
