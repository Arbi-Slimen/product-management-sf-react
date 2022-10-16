<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function filterAndPagination($page, $limit, $productName, $category, $price, $averageScore)
    {

        return $this->createQueryBuilder('p')
            ->select('p')
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.reviews', 'r')
            ->where('p.productName like :productName')
            ->setParameter('productName', '%' . $productName . '%')
            ->andWhere('p.price > :price')
            ->setParameter('price', $price)
            ->andWhere('c.category like :category')
            ->setParameter('category', '%' . $category . '%')
            ->Having('AVG(r.value)> :averageScore')
            ->setParameter('averageScore', $averageScore)
            ->groupBy('p.id')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Integer count of Product objects
     */
    public function countProducts($productName, $category, $price, $averageScore)
    {
        return count($this->createQueryBuilder('p')
            ->select('p')
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.reviews', 'r')
            ->where('p.productName like :productName')
            ->setParameter('productName', '%' . $productName . '%')
            ->andWhere('p.price > :price')
            ->setParameter('price', $price)
            ->andWhere('c.category like :category')
            ->setParameter('category', '%' . $category . '%')
            ->having('AVG(r.value) > :averageScore')
            ->setParameter('averageScore', $averageScore)
            ->groupBy('p.id')
            ->getQuery()
            ->getResult());
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
