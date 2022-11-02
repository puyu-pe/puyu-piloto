<?php

namespace App\Saas\Directory\Infrastructure\Persistence\Doctrine\Repository;

use App\Saas\Directory\Domain\Directory;
use App\Saas\Directory\Domain\Repository\DirectoryRepository;
use App\Shared\Domain\ValueObjects\Uuid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<\App\Saas\Directory\Domain\Directory>
 *
 * @method Directory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Directory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Directory[]    findAll()
 * @method Directory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineDirectoryRepository extends ServiceEntityRepository implements DirectoryRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Directory::class);
    }

    public function save(Directory $directory): void
    {
        $this->add($directory, true);
    }

    public function delete(Directory $directory): void
    {
        $this->remove($directory, true);
    }

    public function search(Uuid $id): ?Directory
    {
        return $this->find($id);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function add(Directory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Directory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Directory[] Returns an array of Directory objects
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

//    public function findOneBySomeField($value): ?Directory
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
