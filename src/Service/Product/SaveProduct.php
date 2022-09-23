<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Form\Type\Product\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class SaveProduct
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface   $formFactory
    ) {
    }

    public function __invoke(Request $request): array
    {
        $product = new Product();
        $form = $this->formFactory->create(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return [$product, null];
        }

        return [$product, null];
    }
}
