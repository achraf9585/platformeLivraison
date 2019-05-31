<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeArticleSupplementRepository")
 */
class CommandeArticleSupplement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="commandeArticleSupplements")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplement", inversedBy="commandeArticleSupplements")
     */
    private $supplement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="commandeArticleSupplements")
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getSupplement(): ?Supplement
    {
        return $this->supplement;
    }

    public function setSupplement(?Supplement $supplement): self
    {
        $this->supplement = $supplement;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
