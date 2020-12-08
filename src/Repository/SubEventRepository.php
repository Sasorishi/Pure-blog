<?php

namespace App\Repository;

use App\Entity\SubEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubEvent[]    findAll()
 * @method SubEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubEvent::class);
    }

    // /**
    //  * @return SubEvent[] Returns an array of SubEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubEvent
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
