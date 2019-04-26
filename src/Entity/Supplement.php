<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\SupplementRepository")
 */
class Supplement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    public function __toString()
    {
        return (string) $this->getLibele();
    }

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *        pattern  = "/[^a-z A-Z À-þ 0-9]+/",
     *     match=false,
     *
     * )
     */
    private $libele;

    /**
     * @ORM\Column(type="float")
     * @Assert\Regex(
     *        pattern  = "/[^0-9 .]+/",
     *     match=false,
     *
     * )
     */
    private $prix;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", mappedBy="supplements")
     */
    private $articles;



    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibele(): ?string
    {
        return $this->libele;
    }

    public function setLibele(string $libele): self
    {
        $this->libele = $libele;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
        }

        return $this;
    }
}
