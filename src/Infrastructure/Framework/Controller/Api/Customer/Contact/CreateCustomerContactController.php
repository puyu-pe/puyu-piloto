<?php

namespace App\Infrastructure\Framework\Controller\Api\Customer\Contact;

use App\Application\Exception\Customer\CustomerContactDataException;
use App\Application\UseCase\Customer\Contact\Create\CreateCustomerContactCommand;
use App\Application\UseCase\Customer\Contact\Create\CreateCustomerContactCommandHandler;
use App\Infrastructure\Utils\FOSRest\FOSRestCustomController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\SerializerStamp;
use Symfony\Component\Serializer\SerializerInterface;

class CreateCustomerContactController extends FOSRestCustomController
{
    #[Rest\Post(path: '/customer_contact', name: 'customer_contact_save')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function __invoke(
        SerializerInterface $serializer,
        MessageBusInterface $bus,
        Request $request,
    ): Response {
        try {
            $command = $serializer->deserialize($request->getContent(), CreateCustomerContactCommand::class, 'json');
            $envelope = $bus->dispatch($command);
            $handledStamp = $envelope->last(HandledStamp::class);
            $customerContact = $handledStamp->getResult();
            return $this->HttpResponse($customerContact, Response::HTTP_CREATED);
        } catch (CustomerContactDataException $e) {
            return $this->HttpResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->HttpResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}