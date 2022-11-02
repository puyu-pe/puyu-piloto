<?php

namespace App\Saas\Project\Application\Edit;

use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Service\FindCustomer as DomainFindCustomer;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Saas\Product\Domain\Service\FindProduct as DomainFindProduct;
use App\Saas\Project\Domain\Exception\ProjectDataException;
use App\Saas\Project\Domain\Exception\ProjectNotFound;
use App\Saas\Project\Domain\Project;
use App\Saas\Project\Domain\Repository\ProjectRepository;
use App\Saas\Project\Domain\Service\FindProject;
use App\Saas\Shared\Domain\Validation\Validator;

class EditProject
{
    private DomainFindCustomer $customerFinder;
    private DomainFindProduct $productFinder;
    private FindProject $finder;

    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly ProductRepository $productRepository,
        private readonly ProjectRepository $repository,
        private readonly Validator $validator,
    ) {
        $this->customerFinder = new DomainFindCustomer($this->customerRepository);
        $this->productFinder = new DomainFindProduct($this->productRepository);
        $this->finder = new FindProject($repository);
    }

    /**
     * @throws ProjectDataException
     * @throws ProjectNotFound
     * @throws CustomerNotFound
     * @throws ProductNotFound
     */
    public function __invoke(
        string $id,
        EditProjectDto $dto,
    ): Project {
        $this->guard($dto);
        $project = ($this->finder)($id);

        $customer = ($this->customerFinder)($dto->getCustomerId());
        $product = ($this->productFinder)($dto->getProductId());

        $project
            ->setCustomer($customer)
            ->setProduct($product);

        $this->repository->save($project);

        return $project;
    }

    /**
     * @throws ProjectDataException
     */
    public function guard(EditProjectDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            $error = $errors[0];
            throw new ProjectDataException($error->getField(), $error->getMessage());
        }
    }
}
