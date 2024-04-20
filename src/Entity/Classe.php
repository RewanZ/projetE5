<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Matiere::class, mappedBy: 'classes')]
    private Collection $classes;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Matiere::class)]
    private Collection $matieres;

    #[ORM\Column(length: 70)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $code = null;


    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->matieres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, matiere>
     */
    public function getIdClasse(): Collection
    {
        return $this->classes;
    }

    public function addIdClasse(matiere $idClasse): static
    {
        if (!$this->classes->contains($idClasse)) {
            $this->classes->add($idClasse);
        }

        return $this;
    }

    public function removeIdClasse(matiere $idClasse): static
    {
        $this->classes->removeElement($idClasse);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getIdUser(): Collection
    {
        return $this->users;
    }

    public function addIdUser(User $idUser): static
    {
        if (!$this->users->contains($idUser)) {
            $this->users->add($idUser);
            $idUser->setClasse($this);
        }

        return $this;
    }

    public function removeIdUser(User $idUser): static
    {
        if ($this->users->removeElement($idUser)) {
            // set the owning side to null (unless already changed)
            if ($idUser->getClasse() === $this) {
                $idUser->setClasse(null);
            }
        }

        return $this;
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

    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): static
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->addClass($this); // Ajoutez la classe à la matière également
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            $matiere->removeClass($this); // Retirez également la classe de la matière
        }

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }


}
