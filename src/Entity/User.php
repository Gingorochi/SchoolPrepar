<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    private ?string $role = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etablissement $etablissement = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Filiere $filiere = null;

    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'organisateur')]
    private $evenementsOrganises;

    public function __construct()
    {
        $this->evenementsOrganises = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?Etablissement $etablissement): static
    {
        $this->etablissement = $etablissement;
        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): static
    {
        $this->filiere = $filiere;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, Evenement>
     */
    public function getEvenementsOrganises(): \Doctrine\Common\Collections\Collection
    {
        return $this->evenementsOrganises;
    }

    public function addEvenementsOrganise(Evenement $evenementsOrganise): static
    {
        if (!$this->evenementsOrganises->contains($evenementsOrganise)) {
            $this->evenementsOrganises->add($evenementsOrganise);
            $evenementsOrganise->setOrganisateur($this);
        }
        return $this;
    }

    public function removeEvenementsOrganise(Evenement $evenementsOrganise): static
    {
        if ($this->evenementsOrganises->removeElement($evenementsOrganise)) {
            if ($evenementsOrganise->getOrganisateur() === $this) {
                $evenementsOrganise->setOrganisateur(null);
            }
        }
        return $this;
    }
}
