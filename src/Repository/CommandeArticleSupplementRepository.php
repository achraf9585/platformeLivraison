<?php

namespace App\Repository;

use App\Entity\CommandeArticleSupplement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandeArticleSupplement|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeArticleSupplement|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeArticleSupplement[]    findAll()
 * @method CommandeArticleSupplement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeArticleSupplementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandeArticleSupplement::class);
    }

    // /**
    //  * @return CommandeArticleSupplement[] Returns an array of CommandeArticleSupplement objects
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
    public function findOneBySomeField($value): ?CommandeArticleSupplement
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
