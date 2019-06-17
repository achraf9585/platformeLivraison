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
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande_article", inversedBy="commandeArticleSupplements")
     */
    private $commande_article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplement", inversedBy="commandeArticleSupplements")
     */
    private $supplement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandeArticle(): ?Commande_article
    {
        return $this->commande_article;
    }

    public function setCommandeArticle(?Commande_article $commande_article): self
    {
        $this->commande_article = $commande_article;

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
}
