<?php

namespace App\Repository;

use App\Entity\Categoriesarticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categoriesarticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoriesarticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoriesarticle[]    findAll()
 * @method Categoriesarticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoriesarticle::class);
    }

    // /**
    //  * @return Categoriesarticle[] Returns an array of Categoriesarticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categoriesarticle
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
