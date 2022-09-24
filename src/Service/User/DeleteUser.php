<?php

namespace App\Service\User;

use App\Model\Exception\User\UserNotFound;
use Doctrine\ORM\EntityManagerInterface;

class DeleteUser
{
    public function __construct(
        private readonly GetUser $getUser,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(int $id): void
    {
        $User = ($this->getUser)($id);
        $this->entityManager->remove($User);
        $this->entityManager->flush();
    }
}
