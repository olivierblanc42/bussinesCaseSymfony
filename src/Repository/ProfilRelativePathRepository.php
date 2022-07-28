<?php

namespace App\Repository;

use App\Entity\ProfilRelativePath;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProfilRelativePath>
 *
 * @method ProfilRelativePath|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilRelativePath|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilRelativePath[]    findAll()
 * @method ProfilRelativePath[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilRelativePathRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilRelativePath::class);
    }

    public function add(ProfilRelativePath $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProfilRelativePath $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProfilRelativePath[] Returns an array of ProfilRelativePath objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProfilRelativePath
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
