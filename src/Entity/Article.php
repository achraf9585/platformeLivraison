<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\CommandeArticleSupplement;



/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @Vich\Uploadable
 */
class Article
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
     *        pattern  = "/[^a-z A-Z À-þ 0-9]+/",
     *     match=false,
     *
     * )
     */
    protected $libele;


    /**
     * @ORM\Column(type="float")
     * @Assert\Regex(
     *        pattern  = "/[^0-9 .]+/",
     *     match=false,
     *     message="le numero ne doit  contenir des chiffres"
     * )
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Supplement", inversedBy="articles")
     */
    public $supplements;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="articles", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;



    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="articles")
     */
    private $fournisseur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etatArticle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeArticleSupplement", mappedBy="article")
     */
    private $commandeArticleSupplements;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commande_article", mappedBy="articles",cascade={"persist","remove"})
     */
    private $commandes;






    public function __construct()
    {
        $this->supplements = new ArrayCollection();
        $this->commandeArticleSupplements = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibele()
    {
        return $this->libele;
    }

    public function setLibele(string $libele)
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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Supplement[]
     */
    public function getSupplements(): Collection
    {
        return $this->supplements;
    }

    public function addSupplement(Supplement $supplement): self
    {
        if (!$this->supplements->contains($supplement)) {
            $this->supplements[] = $supplement;
            $supplement->addArticle($this);
        }

        return $this;
    }

    public function removeSupplement(Supplement $supplement): self
    {
        if ($this->supplements->contains($supplement)) {
            $this->supplements->removeElement($supplement);
            $supplement->removeArticle($this);
        }

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getEtatArticle(): ?string
    {
        return $this->etatArticle;
    }

    public function setEtatArticle(string $etatArticle): self
    {
        $this->etatArticle = $etatArticle;

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
            $commandeArticleSupplement->setArticle($this);
        }

        return $this;
    }

    public function removeCommandeArticleSupplement(CommandeArticleSupplement $commandeArticleSupplement): self
    {
        if ($this->commandeArticleSupplements->contains($commandeArticleSupplement)) {
            $this->commandeArticleSupplements->removeElement($commandeArticleSupplement);
            // set the owning side to null (unless already changed)
            if ($commandeArticleSupplement->getArticle() === $this) {
                $commandeArticleSupplement->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addArticle($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            $commande->removeArticle($this);
        }

        return $this;
    }


}
