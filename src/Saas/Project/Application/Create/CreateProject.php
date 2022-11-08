<?php

namespace App\Saas\Project\Application\Create;

use App\Saas\Customer\Domain\Exception\CustomerNotFound;
use App\Saas\Customer\Domain\Repository\CustomerRepository;
use App\Saas\Customer\Domain\Service\FindCustomer as DomainFindCustomer;
use App\Saas\Product\Domain\Exception\ProductNotFound;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Saas\Product\Domain\Service\FindProduct as DomainFindProduct;
use App\Saas\Project\Domain\Exception\ProjectDataException;
use App\Saas\Project\Domain\Project;
use App\Saas\Project\Domain\Repository\ProjectRepository;
use App\Saas\Shared\Domain\Validation\Validator;

class CreateProject
{
    private DomainFindCustomer $customerFinder;
    private DomainFindProduct $productFinder;

    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly ProductRepository $productRepository,
        private readonly ProjectRepository $projectRepository,
        private readonly Validator $validator,
    ) {
        $this->customerFinder = new DomainFindCustomer($this->customerRepository);
        $this->productFinder = new DomainFindProduct($this->productRepository);
    }

    /**
     * @throws ProjectDataException
     * @throws CustomerNotFound
     * @throws ProductNotFound
     */
    public function __invoke(
        CreateProjectDto $dto
    ): Project {
        $this->guard($dto);

        $customer = ($this->customerFinder)($dto->getCustomerId());
        $product = ($this->productFinder)($dto->getProductId());

        $project = Project::create(
            $customer,
            $product,
            $dto->getKey(),
            $dto->getStartDate(),
            $dto->getLogo(),
            $dto->getColor(),
            $dto->getDescription(),
            $dto->getObservation(),
            $dto->getConfigData(),
            $dto->isSuspended()
        );

        $this->projectRepository->save($project);
        return $project;
    }

    /**
     * @throws ProjectDataException
     */
    public function guard(CreateProjectDto $project): void
    {
        $errors = $this->validator->validate($project);
        if (count($errors)) {
            $error = $errors[0];
            throw new ProjectDataException($error->getField(), $error->getMessage());
        }
    }
}
