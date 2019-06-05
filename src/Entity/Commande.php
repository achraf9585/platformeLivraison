<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Security;
use Symfony\Flex\Response;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datecommande;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datechoixliv;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateconfirmliv;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $codeconfirmlivfour;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateconfirmlivcli;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $codeconfirmlivcli;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $total;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="commandes")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Livreur", inversedBy="commandes")
     */
    private $livreur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeArticleSupplement", mappedBy="commande")
     */
    private $commandeArticleSupplements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande_article", mappedBy="commandes",cascade={"persist","remove"})
     */
    private $articles;


    public function generateRandomString($length = 5, $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public function __construct()
    {
        $this->commandeArticleSupplements = new ArrayCollection();
        $this->datecommande= new \DateTime();
        $this->codeconfirmlivcli= $this->generateRandomString(5);
        $this->codeconfirmlivfour= $this->generateRandomString(5);

        $this->etat="en attente";
        $this->total=0;
        $this->articles = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setDatecommande(?\DateTimeInterface $datecommande): self
    {
        $this->datecommande = $datecommande;

        return $this;
    }

    public function getDatechoixliv(): ?\DateTimeInterface
    {
        return $this->datechoixliv;
    }

    public function setDatechoixliv(?\DateTimeInterface $datechoixliv): self
    {
        $this->datechoixliv = $datechoixliv;

        return $this;
    }

    public function getDateconfirmliv(): ?\DateTimeInterface
    {
        return $this->dateconfirmliv;
    }

    public function setDateconfirmliv(?\DateTimeInterface $dateconfirmliv): self
    {
        $this->dateconfirmliv = $dateconfirmliv;

        return $this;
    }

    public function getCodeconfirmlivfour(): ?string
    {
        return $this->codeconfirmlivfour;
    }

    public function setCodeconfirmlivfour(?string $codeconfirmlivfour): self
    {
        $this->codeconfirmlivfour = $codeconfirmlivfour;

        return $this;
    }

    public function getDateconfirmlivcli(): ?\DateTimeInterface
    {
        return $this->dateconfirmlivcli;
    }

    public function setDateconfirmlivcli(?\DateTimeInterface $dateconfirmlivcli): self
    {
        $this->dateconfirmlivcli = $dateconfirmlivcli;

        return $this;
    }

    public function getCodeconfirmlivcli(): ?string
    {
        return $this->codeconfirmlivcli;
    }

    public function setCodeconfirmlivcli(?string $codeconfirmlivcli): self
    {
        $this->codeconfirmlivcli = $codeconfirmlivcli;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTempslivraison(): ?int
    {
        return $this->tempslivraison;
    }

    public function setTempslivraison(?int $tempslivraison): self
    {
        $this->tempslivraison = $tempslivraison;

        return $this;
    }

    public function getTempspreparation(): ?int
    {
        return $this->tempspreparation;
    }

    public function setTempspreparation(?int $tempspreparation): self
    {
        $this->tempspreparation = $tempspreparation;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommandeArticleSupplements()
    {
        return $this->commandeArticleSupplements;
    }

    /**
     * @param mixed $commandeArticleSupplements
     */
    public function setCommandeArticleSupplements($commandeArticleSupplements)
    {
        $this->commandeArticleSupplements = $commandeArticleSupplements;
    }

    public function addCommandeArticleSupplement(CommandeArticleSupplement $commandeArticleSupplement): self
    {
        if (!$this->commandeArticleSupplements->contains($commandeArticleSupplement)) {
            $this->commandeArticleSupplements[] = $commandeArticleSupplement;
            $commandeArticleSupplement->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeArticleSupplement(CommandeArticleSupplement $commandeArticleSupplement): self
    {
        if ($this->commandeArticleSupplements->contains($commandeArticleSupplement)) {
            $this->commandeArticleSupplements->removeElement($commandeArticleSupplement);
            // set the owning side to null (unless already changed)
            if ($commandeArticleSupplement->getCommande() === $this) {
                $commandeArticleSupplement->setCommande(null);
            }
        }

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
