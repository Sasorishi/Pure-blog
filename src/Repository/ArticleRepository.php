<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findById($id): ?array
    {
        // select idArticle, label, title, content, thumbnail, created, status, firstName, lastName, avatar from categoriesArticle inner join article on categoriesArticle.idCategorie = article.idCategorie inner join administrator on article.idAdmin = administrator.idAdmin;
        
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a.idarticle, c.label, a.title, a.content, a.thumbnail, a.created, a.status, a.lead, u.firstname, u.lastname, u.avatar from App\Entity\Categoriesarticle c LEFT JOIN App\Entity\Article a WITH c.idcategorie = a.idcategorie LEFT JOIN App\Entity\Administrator u WITH a.idadmin = u.idadmin where a.idarticle = :id'
        )->setParameter('id', $id);

        // returns an array of Product objects
        return $query->getOneOrNullResult();
    }

    public function findAllArticles(): ?array
    {
        // select idArticle, label, title, content, thumbnail, created, status, firstName, lastName, avatar from categoriesArticle inner join article on categoriesArticle.idCategorie = article.idCategorie inner join administrator on article.idAdmin = administrator.idAdmin;
        
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a.idarticle, c.label, a.title, a.content, a.thumbnail, a.created, a.status, a.lead, u.firstname, u.lastname, u.avatar from App\Entity\Categoriesarticle c INNER JOIN App\Entity\Article a WITH c.idcategorie = a.idcategorie INNER JOIN App\Entity\Administrator u WITH a.idadmin = u.idadmin ORDER BY a.created DESC'
        );

        // returns an array of Product objects
        return $query->getResult();
    }

}
