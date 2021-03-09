<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Post[]
     */
    public function findByTopics($id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p.content, p.created, u.nickname, u.avatar, u.iduser  FROM App\Entity\Post p INNER JOIN App\Entity\User u WITH p.iduser = u.iduser WHERE p.idtopics = :id ORDER BY p.created ASC'
        )->setParameter('id', $id);
        
        // returns an array of Product objects
        return $query->getResult();
    }

    public function findCategorieName($id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c.idcategorie, c.label FROM App\Entity\Post p INNER JOIN App\Entity\Topics t WITH p.idtopics = t.idtopics INNER JOIN App\Entity\Categoriesforum c WITH t.idcategorie = c.idcategorie WHERE p.idtopics = :id'
        )->setParameter('id', $id);
        
        // select post.idTopics, categoriesforum.label from post left join topics on post.idTopics = topics.idTopics left join categoriesforum on topics.idCategorie = categoriesForum.idCategorie where post.idTopics = 33;
        // returns an array of Product objects
        return $query->getResult();
    }
}
