<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 04/06/2019
 * Time: 01:48
 */

namespace App\Repository;


use App\Entity\Commande_article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandeArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeArticle[]    findAll()
 * @method CommandeArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commande_article::class);
    }
}