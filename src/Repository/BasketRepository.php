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


    // get the number of command
    public function getTotalcommande(?\DateTime $startDate = null, ?\DateTime $endDate = null): array
    {

        if ($startDate === null || $endDate === null) {
            $endDate = new \DateTime('now');
            $startDate = new \DateTime('2020-01-01');
        }

        return $this->createQueryBuilder('basket')
            ->select('count(basket)')
            ->join('basket.commandStatus', 'commandStatus')
            ->where('commandStatus.label = :valid')
            ->setParameter('valid', 'valide')
            ->andWhere('basket.dateCreated BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getOneOrNullResult();
    }


    // the average price of basket
    public function getBasketAverageValue(?\DateTime $startDate = null, ?\DateTime $endDate = null): array
    {
        if ($startDate === null || $endDate === null) {
            $endDate = new \DateTime('now');
            $startDate = new \DateTime('2020-01-01');
        }


        return $this->createQueryBuilder('basket')
            ->select('AVG(basketQuantityInBasket.price)')
            ->join('basket.basketQuantityInBasket', 'basketQuantityInBasket')
            ->andWhere('basket.dateCreated BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getOneOrNullResult();
    }



   // count the total sale of the site

    public function getSales(?\DateTime $startDate = null, ?\DateTime $endDate = null): array
    {

        if ($startDate === null || $endDate === null) {
            $endDate = new \DateTime('now');
            $startDate = new \DateTime('2020-01-01');
        }
        return $this->createQueryBuilder('basket')
            ->select('commandStatus', 'SUM(basketQuantityInBasket.price)', 'basket')
            ->join('basket.commandStatus', 'commandStatus')
            ->join('basket.basketQuantityInBasket', 'basketQuantityInBasket')
            ->groupBy('basketQuantityInBasket.price')
            ->where('commandStatus.label = :valid')
            ->setParameter('valid', 'valide')
            ->andWhere('basket.dateCreated BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getOneOrNullResult();

    }


    //count the number of basket canceled
    public function getBasketCanceled(?\DateTime $startDate = null, ?\DateTime $endDate = null): array
    {
        if ($startDate === null || $endDate === null) {
            $endDate = new \DateTime('now');
            $startDate = new \DateTime('2020-01-01');
        }


        return $this->createQueryBuilder('basket')
            ->select('count(basket)')
            ->join('basket.commandStatus', 'commandStatus')
            ->where('commandStatus.label = :annul')
            ->setParameter('annul', 'Annuler')
            ->andWhere('basket.dateCreated BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // count the number of basket

    public function getNumberBasket(?\DateTime $startDate = null, ?\DateTime $endDate = null): array
    {

        if ($startDate === null || $endDate === null) {
            $endDate = new \DateTime('now');
            $startDate = new \DateTime('2020-01-01');
        }
        // SELECT * FROM game AS game
        return $this->createQueryBuilder('basket')
            ->select('Count(basket)')
            ->andWhere('basket.dateCreated BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getOneOrNullResult();
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
