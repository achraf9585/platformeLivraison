<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LivreurRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Livreur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=180)
     */
    private $nom;
    /**
     * @ORM\Column(type="string", length=180)
     */
    private $prenom;
    /**
     * @ORM\Column(type="string", length=8)
     */
    private $numtel1;
    /**
     * @ORM\Column(type="string", length=8)
     */
    private $numtel2;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $etat;

    /**
     * @ORM\Column(type="float")
     */
    private $commission;
    /**
     * @ORM\Column(type="string", length=180)
     */
    private $typevehicule;
    /**
     * @ORM\Column(type="string", length=180)
     */
    private $typepapier;
    /**
     * @ORM\Column(type="string", length=180)
     */
    private $numpapier;
    /**
     * @ORM\Column(type="string", length=180)
     */
    private $localisation;
    /**
     * @ORM\Column(type="string", length=180)
     */
    private $disponibilite;
    /**
     * @ORM\Column(type="date" )
     */
    private $datenaissance;
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }


    public $confirm_password;

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getNumtel1()
    {
        return $this->numtel1;
    }

    /**
     * @param mixed $numtel1
     */
    public function setNumtel1($numtel1): void
    {
        $this->numtel1 = $numtel1;
    }

    /**
     * @return mixed
     */
    public function getNumtel2()
    {
        return $this->numtel2;
    }

    /**
     * @param mixed $numtel2
     */
    public function setNumtel2($numtel2): void
    {
        $this->numtel2 = $numtel2;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param mixed $commission
     */
    public function setCommission($commission): void
    {
        $this->commission = $commission;
    }

    /**
     * @return mixed
     */
    public function getTypevehicule()
    {
        return $this->typevehicule;
    }

    /**
     * @param mixed $typevehicule
     */
    public function setTypevehicule($typevehicule): void
    {
        $this->typevehicule = $typevehicule;
    }

    /**
     * @return mixed
     */
    public function getTypepapier()
    {
        return $this->typepapier;
    }

    /**
     * @param mixed $typepapier
     */
    public function setTypepapier($typepapier): void
    {
        $this->typepapier = $typepapier;
    }

    /**
     * @return mixed
     */
    public function getNumpapier()
    {
        return $this->numpapier;
    }

    /**
     * @param mixed $numpapier
     */
    public function setNumpapier($numpapier): void
    {
        $this->numpapier = $numpapier;
    }

    /**
     * @return mixed
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param mixed $localisation
     */
    public function setLocalisation($localisation): void
    {
        $this->localisation = $localisation;
    }

    /**
     * @return mixed
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * @param mixed $disponibilite
     */
    public function setDisponibilite($disponibilite): void
    {
        $this->disponibilite = $disponibilite;
    }

    /**
     * @return mixed
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * @param mixed $datenaissance
     */
    public function setDatenaissance($datenaissance): void
    {
        $this->datenaissance = $datenaissance;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
