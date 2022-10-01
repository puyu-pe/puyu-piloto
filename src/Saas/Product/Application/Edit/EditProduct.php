<?php

namespace App\Saas\Product\Application\Edit;

use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Exception\ProductDataException;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Saas\Product\Domain\Service\FindProduct;
use App\Saas\Shared\Domain\Validation\Validator;

class EditProduct
{
    private FindProduct $finder;

    public function __construct(
        private readonly ProductRepository $repository,
        private readonly Validator $validator,
    ) {
        $this->finder = new FindProduct($repository);
    }

    /**
     * @throws ProductDataException
     * @throws ProductNotFound
     */
    public function __invoke(
        string $id,
        EditProductDto $dto,
    ): Product {
        $this->guard($dto);
        $product = ($this->finder)($id);

        $product
            ->setCode($dto->getCode())
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
            ->setUrl($dto->getUrl())
            ->setImage($dto->getImage());

        $this->repository->save($product);

        return $product;
    }

    /**
     * @throws \App\Saas\Product\Domain\Exception\ProductDataException
     */
    public function guard(EditProductDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            $error = $errors[0];
            throw new ProductDataException($error->getField(), $error->getMessage());
        }
    }
}
