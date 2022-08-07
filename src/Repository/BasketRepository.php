<?php

namespace App\Repository;

use App\Entity\Basket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

/**
 * @extends ServiceEntityRepository<Basket>
 *
 * @method Basket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Basket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Basket[]    findAll()
 * @method Basket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Basket::class);
    }

    public function add(Basket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Basket $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTotalcommande()
    {
        return $this->createQueryBuilder('basket')
            ->select('count(basket)')
            ->join('basket.commandStatus', 'commandStatus')
            ->where('commandStatus.label = :valid')
            ->setParameter('valid', 'valide')
            ->getQuery()
            ->getResult();
    }

    public function getBasketAverageValue()
    {
        return $this->createQueryBuilder('basket')
            ->select('AVG(basketQuantityInBasket.price)')
            ->join('basket.basketQuantityInBasket', 'basketQuantityInBasket')
            ->getQuery()
            ->getResult();
    }





    public function getSales()
    {
        return $this->createQueryBuilder('basket')
            ->select('commandStatus', 'SUM(basketQuantityInBasket.price)', 'basket')
            ->join('basket.commandStatus', 'commandStatus')
            ->join('basket.basketQuantityInBasket', 'basketQuantityInBasket')
            ->groupBy('basketQuantityInBasket.price')
            ->where('commandStatus.label = :valid')
            ->setParameter('valid', 'valide')
            ->getQuery()
            ->getResult();
    }

    public function getBasketCanceled()
    {
        return $this->createQueryBuilder('basket')
            ->select('count(basket)')
            ->join('basket.commandStatus', 'commandStatus')
            ->where('commandStatus.label = :annul')
            ->setParameter('annul', 'Annuler')
            ->getQuery()
            ->getResult();
    }


    public function getNumberBasket(): array
    {
        // SELECT * FROM game AS game
        return $this->createQueryBuilder('basket')
            ->select('Count(basket)')
            ->getQuery()
            ->getResult();
    }




    /**
     * @throws NonUniqueResultException
     */
    public function getBasketPercentageAbandoned(): array
    {
        $total = $this->createQueryBuilder('basket')
            ->select('count(basket) AS total')
            ->getQuery()
           ->getOneOrNullResult();

        $abandoned = $this->createQueryBuilder('basket')
            ->select('count(basket) AS Abbandon')
            ->join('basket.commandStatus', 'commandStatus')
            ->where('commandStatus.label = :annul')
            ->setParameter('annul', 'Annuler')
            ->getQuery()
            ->getOneOrNullResult();

       $result['abandon panier %'] = round(($abandoned['Abbandon'] / $total['total']) * 100, 2);

        return $result;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getBasketPercentagecommand(): array
    {
        $total = $this->createQueryBuilder('basket')
            ->select('COUNT(basket) AS total ')
            ->getQuery()
            ->getOneOrNullResult();

        $command = $this->createQueryBuilder('basket')
            ->select('COUNT(basket) AS command')
            ->join('basket.commandStatus', 'commandStatus')
            ->where('commandStatus.label = :valid')
            ->setParameter('valid', 'valide')
            ->getQuery()
            ->getOneOrNullResult();

        $result[' panier in command %'] = round(($command['command'] / $total['total']) * 100, 2);

        return $result;
    }



    public function getConvertingBaskets(): array
    {
        return $this->createQueryBuilder('basket')
            ->select('count(basket)')
            ->getQuery()
            ->getOneOrNullResult();


    }



    public function getBasketPer(): array
    {
        // SELECT * FROM game AS game
        return $this->createQueryBuilder('basket')
            ->select('SUM(basket)' / '')
            ->join('basket.commandStatus', 'commandStatus')
            ->getQuery()
            ->getResult();
    }



//    /**
//     * @return Basket[] Returns an array of Basket objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Basket
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
