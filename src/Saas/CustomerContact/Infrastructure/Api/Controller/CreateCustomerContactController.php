<?php

namespace App\Saas\CustomerContact\Infrastructure\Api\Controller;

use App\Saas\CustomerContact\Application\Create\CreateProductDto;
use App\Saas\CustomerContact\Application\Create\CreateProductUseCase;
use App\Saas\CustomerContact\Domain\Exception\ProductDataException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateCustomerContactController extends AbstractFOSRestController
{
    #[Rest\Post(name: 'customer_contact_save')]
    public function __invoke(
        CreateProductUseCase $useCase,
        SerializerInterface $serializer,
        Request $request,
    ): Response {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateProductDto::class, 'json');
            $customerContact = ($useCase)($dto);

            $view = View::create(
                ['customerContact' => $customerContact],
                Response::HTTP_OK
            );
            $view->getContext()->setGroups(['customer_contact']);
        } catch (ProductDataException $exception) {
            $view = View::create($exception, Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
