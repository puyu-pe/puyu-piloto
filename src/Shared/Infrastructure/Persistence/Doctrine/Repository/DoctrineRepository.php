<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist(mixed $entity): void
    {
        $this->entityManager()->persist($entity);
    }

    protected function remove(mixed $entity): void
    {
        $this->entityManager()->remove($entity);
    }

    /**
     * @template TEntityClass of object
     * @param class-string<TEntityClass> $entityClass
     * @return EntityRepository<TEntityClass>
     */
    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }
}
