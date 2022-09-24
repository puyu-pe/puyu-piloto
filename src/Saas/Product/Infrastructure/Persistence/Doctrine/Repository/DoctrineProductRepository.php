<?php

namespace App\Saas\Product\Infrastructure\Persistence\Doctrine\Repository;

use App\Saas\CustomerContact\Domain\Entity\CustomerContact;
use App\Saas\CustomerContact\Domain\Repository\CustomerContactRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<CustomerContact>
 *
 * @method CustomerContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerContact[]    findAll()
 * @method CustomerContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineProductRepository extends ServiceEntityRepository implements CustomerContactRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerContact::class);
    }

    public function save(CustomerContact $customerContact): void
    {
        $this->add($customerContact, true);
    }

    public function delete(CustomerContact $customerContact): void
    {
        $this->remove($customerContact, true);
    }

    public function search(Uuid $id): ?CustomerContact
    {
        return $this->find($id);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function add(CustomerContact $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerContact $entity, bool $flush = false): void
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
