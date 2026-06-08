<?php

namespace App\Entity;

use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FiliereRepository::class)]
class Filiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom de la filière est obligatoire')]
    #[Assert\Length(min: 2, minMessage: 'Le nom doit contenir au moins {{ limit }} caractères', max: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le domaine est obligatoire')]
    #[Assert\Length(min: 2, minMessage: 'Le domaine doit contenir au moins {{ limit }} caractères', max: 100)]
    private ?string $domaine = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'La description est obligatoire')]
    #[Assert\Length(min: 10, minMessage: 'La description doit contenir au moins {{ limit }} caractères', max: 2000)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'La durée est obligatoire')]
    #[Assert\Positive(message: 'La durée doit être un nombre positif')]
    #[Assert\LessThanOrEqual(10, message: 'La durée ne peut pas dépasser 10 ans')]
    private ?int $duree = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'La langue d\'enseignement est obligatoire')]
    #[Assert\Choice(choices: ['Français', 'Anglais', 'Espagnol', 'Bilingue'], message: 'La langue doit être valide')]
    private ?string $langue = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Le nom du fichier ne peut pas dépasser {{ limit }} caractères')]
    private ?string $image = null;

    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
        mimeTypesMessage: 'Veuillez uploader une image valide (jpeg/png/webp/gif).'
    )]
    private ?\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile = null;


    #[ORM\ManyToMany(targetEntity: Etablissement::class, inversedBy: 'filieres')]
    private Collection $etablissements;

    #[ORM\OneToMany(targetEntity: Evenement::class, mappedBy: 'filiere')]
    private Collection $evenements;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
        $this->evenements = new ArrayCollection();
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

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): static
    {
        $this->domaine = $domaine;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;
        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): static
    {
        $this->langue = $langue;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getImageFile(): ?\Symfony\Component\HttpFoundation\File\UploadedFile
    {
        return $this->imageFile;
    }

    public function setImageFile(?\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile): static
    {
        $this->imageFile = $imageFile;

        return $this;
    }


    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): static
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->addFiliere($this);
        }
        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): static
    {
        if ($this->etablissements->removeElement($etablissement)) {
            $etablissement->removeFiliere($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setFiliere($this);
        }
        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            if ($evenement->getFiliere() === $this) {
                $evenement->setFiliere(null);
            }
        }
        return $this;
    }
}
