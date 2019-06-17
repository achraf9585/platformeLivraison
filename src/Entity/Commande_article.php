<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 30/05/2019
 * Time: 01:12
 */

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeArticleSupplement", mappedBy="commande_article")
     */
    private $commandeArticleSupplements;

    /**
     * Commande_article constructor.
     */
    public function __construct()
    {
        $this->commandeArticleSupplements = new ArrayCollection();
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
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

    /**
     * @return Collection|CommandeArticleSupplement[]
     */
    public function getCommandeArticleSupplements(): Collection
    {
        return $this->commandeArticleSupplements;
    }

    public function addCommandeArticleSupplement(CommandeArticleSupplement $commandeArticleSupplement): self
    {
        if (!$this->commandeArticleSupplements->contains($commandeArticleSupplement)) {
            $this->commandeArticleSupplements[] = $commandeArticleSupplement;
            $commandeArticleSupplement->setCommandeArticle($this);
        }

        return $this;
    }

    public function removeCommandeArticleSupplement(CommandeArticleSupplement $commandeArticleSupplement): self
    {
        if ($this->commandeArticleSupplements->contains($commandeArticleSupplement)) {
            $this->commandeArticleSupplements->removeElement($commandeArticleSupplement);
            // set the owning side to null (unless already changed)
            if ($commandeArticleSupplement->getCommandeArticle() === $this) {
                $commandeArticleSupplement->setCommandeArticle(null);
            }
        }

        return $this;
    }


}