<?php

namespace App\Repository;

use App\Entity\Categoriesforum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categoriesforum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoriesforum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoriesforum[]    findAll()
 * @method Categoriesforum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesForumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoriesforum::class);
    }

    // /**
    //  * @return Categoriesforum[] Returns an array of Categoriesforum objects
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
    public function findOneBySomeField($value): ?Categoriesforum
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
