<?php

namespace App\Repository;

use App\Entity\NumberVisite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NumberVisite>
 *
 * @method NumberVisite|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumberVisite|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumberVisite[]    findAll()
 * @method NumberVisite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumberVisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NumberVisite::class);
    }

    public function add(NumberVisite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NumberVisite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getVisitBasket(): array
    {
        return $this->createQueryBuilder('number_visite')
            ->select('count(number_visite)')
            ->getQuery()
            ->getOneOrNullResult();


    }

    public function getNewVisit(): array
    {
        return $this->createQueryBuilder('number_visite')
            ->select('count(number_visite)')
            ->getQuery()
            ->getOneOrNullResult();


    }




//    /**
//     * @return NumberVisite[] Returns an array of NumberVisite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NumberVisite
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
