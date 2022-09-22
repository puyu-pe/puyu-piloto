<?php

namespace App\Infrastructure\Framework\Controller\Api\Customer\Contact;

use App\Application\Customer\Contact\Edit\EditCustomerContactDto;
use App\Application\Customer\Contact\Edit\EditCustomerContactUseCase;
use App\Domain\Exception\Customer\Contact\CustomerContactNotFound;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

class EditCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Put(path: '/customer_contact/{id}', name: 'customer_contact_update', requirements: ['id' => Requirement::UUID_V4])]
    public function __invoke(
        string $id,
        Request $request,
        EditCustomerContactUseCase $useCase,
        SerializerInterface $serializer,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), EditCustomerContactDto::class, 'json');
            $customerContact = ($useCase)($id, $dto);

            $view = View::create(
                ['customerContact' => $customerContact],
                Response::HTTP_ACCEPTED
            );
        } catch (CustomerContactNotFound $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }
}
