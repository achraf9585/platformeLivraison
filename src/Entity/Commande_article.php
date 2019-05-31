<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 30/05/2019
 * Time: 01:12
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Commande_article
 * @ORM\Table(name="commande_article")
 * @ORM\Entity
 */
class Commande_article
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;


    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    /**
     * Commande_article constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * @param mixed $qte
     */
    public function setQte($qte)
    {
        $this->qte = $qte;
    }


}