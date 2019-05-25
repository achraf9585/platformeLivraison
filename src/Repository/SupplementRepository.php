<?php

namespace App\Repository;

use App\Entity\Supplement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Supplement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplement[]    findAll()
 * @method Supplement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Supplement::class);
    }

    // /**
    //  * @return Supplement[] Returns an array of Supplement objects
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
    public function findOneBySomeField($value): ?Supplement
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findsuppfour($value): array
    {
        $conn= $this->getEntityManager()->getConnection();
        $sql=' SELECT s.* FROM supplement s , plat p 
 WHERE p.fournisseur_id = :val
';
        $smt= $conn->prepare($sql);
        $smt->execute(['val' => $value]);
        return $smt->fetchAll();
    }
}
