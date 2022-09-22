<?php

namespace App\Infrastructure\Framework\Controller\Api\Customer\Contact;

use App\Application\Customer\Contact\Create\CreateCustomerContactDto;
use App\Application\Customer\Contact\Create\CreateCustomerContactUseCase;
use App\Domain\Exception\Customer\Contact\CustomerContactDataException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Post(path: '/customer_contact', name: 'customer_contact_save')]
    #[Rest\View(serializerGroups: ['customer_contact'])]
    public function __invoke(
        CreateCustomerContactUseCase $useCase,
        SerializerInterface $serializer,
        Request $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateCustomerContactDto::class, 'json');
            $customerContact = ($useCase)($dto);

            $view = View::create(
                ['customerContact' => $customerContact],
                Response::HTTP_OK
            );
        } catch (CustomerContactDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
