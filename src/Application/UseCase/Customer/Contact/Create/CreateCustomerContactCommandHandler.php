<?php

namespace App\Application\UseCase\Customer\Contact\Create;

use App\Domain\Entity\CustomerContact;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateCustomerContactCommandHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly CreateCustomerContactUseCase $useCase
    ) {
    }

    public function __invoke(CreateCustomerContactCommand $command): CustomerContact
    {
        return ($this->useCase)(
            $command->getName(),
            $command->getLastName(),
            $command->getPhone(),
            $command->getJobTitle()
        );
    }
}
