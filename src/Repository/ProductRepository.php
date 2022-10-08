<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends AbstractBusinessCaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
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


    public function getBestProducts(?\DateTime $startDate = null, ?\DateTime $endDate = null): array
    {

        if ($startDate === null || $endDate === null) {
            $endDate = new \DateTime('now');
            $startDate = new \DateTime('2020-01-01');
        }

        // SELECT * FROM user AS user
        return $this->createQueryBuilder('product')
            ->select('product.label', 'quantityInBaskets.quantity')
            ->join('product.quantityInBaskets', 'quantityInBaskets')
            ->orderBy('quantityInBaskets.quantity', 'DESC')
            ->andWhere('basket.dateCreated BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }

//    Souci avec avg and count il m'enleve le paginator'
    public function getQbAll(): QueryBuilder
    {
        $qb = parent::getQbAll();
        return $qb->select('product','brand','productReview','picture','COUNT(productReview.note) AS Numbnote','AVG(productReview.note) AS note')
            ->join('product.review','productReview')
            ->join('product.picture','picture')
            ->join('product.brand','brand')
            ->groupBy('product')
            ;
    }


    /**
     * @throws NonUniqueResultException
     */
    public function findBySlugRelations($slug)
    {
        return $this->createQueryBuilder('product')
            ->select('product', 'brand','picture','COUNT(productReview.note) AS Numbnote','AVG(productReview.note) AS note')
            ->join('product.review','productReview')
            ->join('product.picture','picture')
            ->join('product.brand','brand')
            ->where('product.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();

    }

//    public function  getBestReview(){
//        return $this->createQueryBuilder('product')
//            ->select('product.label','AVG(productReview.note)','product.priceHt','productReview.note','COUNT(productReview.note)')
//            ->join('product.review','productReview')
//            ->groupBy('productReview.note')
//            ->orderBy('AVG(productReview.note)', 'Desc')
//            ->getQuery()
//            ->getResult();
//    }




//    /**
//     * @return Product[] Returns an array of Product objects
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

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
