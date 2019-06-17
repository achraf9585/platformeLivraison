<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
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
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function nbrcom()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->getQuery()
            ->getSingleScalarResult();


    }







    public function findfour($value): array
    {
        $conn= $this->getEntityManager()->getConnection();
        $sql='SELECT
commande.id,commande.datecommande,commande.dateconfirmlivcli,commande.etat,commande.codeconfirmlivfour,
commande_article.commande_id,commande_article.article_id,article.fournisseur_id,fournisseur.nomrestaurant,commande.livreur_id,
livreur.nom, livreur.prenom
FROM commande 
JOIN commande_article on commande_article.commande_id = commande.id
JOIN article on article.id = commande_article.article_id
LEFT JOIN livreur on livreur.id = commande.livreur_id

LEFT JOIN fournisseur on fournisseur.id = article.fournisseur_id
WHERE article.fournisseur_id = 3
GROUP BY commande.id

';
        $smt= $conn->prepare($sql);
        $smt->execute(['val' => $value]);
        return $smt->fetchAll();
    }
}
