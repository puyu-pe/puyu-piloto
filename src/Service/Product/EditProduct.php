<?php

namespace App\Service\Product;

use App\Form\Type\Product\ProductType;
use App\Model\Exception\Product\ProductNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class EditProduct
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly GetProduct $getProduct,
        private readonly DecoderInterface $decoder
    ) {
    }

    /**
     * @throws ProductNotFound
     */

    public function __invoke(
        Request $request,
        int $id
    ): array {
        $product = ($this->getProduct)($id);
        $form = $this->formFactory->create(ProductType::class, $product);
        $form->submit($this->decoder->decode($request->getContent(), 'json'));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return [$product, null];
        }

        return [null, $form];
    }
}
