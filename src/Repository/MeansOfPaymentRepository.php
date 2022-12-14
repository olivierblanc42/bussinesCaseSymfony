<?php

namespace App\Repository;

use App\Entity\MeansOfPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MeansOfPayment>
 *
 * @method MeansOfPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeansOfPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeansOfPayment[]    findAll()
 * @method MeansOfPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeansOfPaymentRepository extends AbstractBusinessCaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeansOfPayment::class);
    }

    public function add(MeansOfPayment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MeansOfPayment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQbAll(): QueryBuilder
    {
        $qb = parent::getQbAll();
        return $qb->select('meansofpayment')
            ;
    }


//    /**
//     * @return MeansOfPayment[] Returns an array of MeansOfPayment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MeansOfPayment
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
