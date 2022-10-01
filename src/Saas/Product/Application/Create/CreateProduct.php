<?php

namespace App\Saas\Product\Application\Create;

use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Exception\ProductDataException;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Saas\Shared\Domain\Validation\Validator;

class CreateProduct
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly Validator $validator,
    ) {
    }

    /**
     * @throws ProductDataException
     */
    public function __invoke(
        CreateProductDto $dto
    ): Product {
        $this->guard($dto);

        $product = Product::create(
            $dto->getCode(),
            $dto->getName(),
            $dto->getDescription(),
            $dto->getUrl(),
            $dto->getImage()
        );

        $this->productRepository->save($product);
        return $product;
    }

    /**
     * @throws ProductDataException
     */
    public function guard(CreateProductDto $product): void
    {
        $errors = $this->validator->validate($product);
        if (count($errors)) {
            $error = $errors[0];
            throw new ProductDataException($error->getField(), $error->getMessage());
        }
    }
}
