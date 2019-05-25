<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
       * @Assert\Regex(
     *        pattern  = "/[^a-z A-Z  À-þ 0-9]+/",
     *     match=false,
     *     message="le libele ne doit pas contenir des chiffres"
     * )
     */
    private $libele;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="villes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fournisseur", mappedBy="region")
     */
    private $fournisseurs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etatVille;

    public function __construct()
    {
        $this->fournisseurs = new ArrayCollection();
    }


    public function getId(): ?string
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

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|Fournisseur[]
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): self
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs[] = $fournisseur;
            $fournisseur->setRegion($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->removeElement($fournisseur);
            // set the owning side to null (unless already changed)
            if ($fournisseur->getRegion() === $this) {
                $fournisseur->setRegion(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getEtatVille(): ?string
    {
        return $this->etatVille;
    }

    public function setEtatVille(string $etatVille): self
    {
        $this->etatVille = $etatVille;

        return $this;
    }


}
