<?php

namespace App\Saas\Product\Infrastructure\Persistence\Doctrine\Repository;

use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\Product\Domain\Entity\Product;
use App\Saas\Product\Domain\Repository\ProductRepository;
use App\Shared\Domain\ValueObjects\Uuid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerContact>
 *
 * @method CustomerContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerContact[]    findAll()
 * @method CustomerContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $this->add($product, true);
    }

    public function delete(Product $product): void
    {
        $this->remove($product, true);
    }

    public function search(Uuid $id): ?Product
    {
        return $this->find($id);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CustomerContact[] Returns an array of CustomerContact objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CustomerContact
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
