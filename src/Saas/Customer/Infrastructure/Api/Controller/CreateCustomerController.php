<?php

namespace App\Saas\Customer\Infrastructure\Api\Controller;

use App\Saas\Customer\Application\Create\CreateCustomerDto;
use App\Saas\Customer\Application\Create\CreateCustomerUseCase;
use App\Saas\Customer\Domain\Exception\CustomerDataException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateCustomerController extends AbstractFOSRestController
{
    #[Rest\Post(name: 'customer_save')]
    public function __invoke(
        CreateCustomerUseCase $useCase,
        SerializerInterface $serializer,
        Request $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateCustomerDto::class, 'json');
            $customer = ($useCase)($dto);

            $view = View::create(
                ['customer' => $customer],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['customer']);
        } catch (CustomerDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
