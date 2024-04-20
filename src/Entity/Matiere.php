<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $designation = null;

    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Demande::class, orphanRemoval: true)]
    private Collection $demandes;

    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: "matieres")]
    #[ORM\JoinTable(name: "classe_matiere")]
    private Collection $classes;

    //    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'matieres')]
//    #[ORM\JoinColumn(name: 'classe_id', referencedColumnName: 'id')]


//    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Demande::class, orphanRemoval: true)]
//    private Collection $demandes;
//
//    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'matieres')]
//    #[ORM\JoinColumn(name: 'classe_id', referencedColumnName: 'id')]
//    private Classe $classes;
    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Competence::class, orphanRemoval: true)]
    private Collection $competences;

    #[ORM\Column]
    private array $sousMatiere = [];

    #[ORM\OneToMany(mappedBy: 'matiere', targetEntity: Soutien::class)]
    private Collection $soutiens;



    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->competences = new ArrayCollection();
        //$this->sousMatiere = [];
        $this->soutiens = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }



    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): static
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setIdMatiere($this);
        }
        
        return $this;
    }

    public function removeDemande(Demande $demande): static
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getIdMatiere() === $this) {
                $demande->setIdMatiere(null);
            }
        }
        return $this;
    }



    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $classes): static
    {
        if (!$this->classes->contains($classes)) {
            $this->classes->add($classes);
            $classes->addIdClasse($this);
        }

        return $this;
    }

    public function removeClass(Classe $classes): static
    {
        if ($this->classes->removeElement($classes)) {
            $classes->removeIdClasse($this);
        }

        return $this;
    }


    public function __toString()
    {
        return $this->getDesignation();
    }

    /**
     * @return Collection<int, Competence>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): static
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
            $competence->setMatiere($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): static
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getMatiere() === $this) {
                $competence->setMatiere(null);
            }
        }

        return $this;
    }
    public function getSousMatiere(): array
    {
        return $this->sousMatiere;
    }

    public function setSousMatiere(array $sousMatiere): static
    {
        $this->sousMatiere = $sousMatiere;

        return $this;
    }



    /**
     * Add a $sousMatiere
     *
     * @param string $sousMatiere
     * @return self
     */
    public function addSousMatiere(string $sousMatiere): self
    {
        $this->sousMatiere[] = $sousMatiere;

        return $this;
    }
    /**
     * Ajoute une nouvelle sousMatiere à la liste des sousMatiere existantes
     *
     * @param string $nouvelleSousMatiere La nouvelle sousMatiere à ajouter
     * @return self
     */
    public function ajouterSousMatiere(string $nouvelleSousMatiere): self
    {
        // Récupérer les anciennes boissons s'il y en a
        $anciennesSousMatieres = $this->sousMatiere ?? [];

        // Ajouter la nouvelle boisson à la liste des anciennes boissons
        $anciennesSousMatieres[] = $nouvelleSousMatiere;

        // Mettre à jour la propriété boisson avec la nouvelle liste de boissons
        $this->sousMatiere = $anciennesSousMatieres;

        return $this;
    }

    /**
     * @return Collection<int, Soutien>
     */
    public function getSoutiens(): Collection
    {
        return $this->soutiens;
    }

    public function addSoutien(Soutien $soutien): static
    {
        if (!$this->soutiens->contains($soutien)) {
            $this->soutiens->add($soutien);
            $soutien->setMatiere($this);
        }

        return $this;
    }

    public function removeSoutien(Soutien $soutien): static
    {
        if ($this->soutiens->removeElement($soutien)) {
            // set the owning side to null (unless already changed)
            if ($soutien->getMatiere() === $this) {
                $soutien->setMatiere(null);
            }
        }

        return $this;
    }



}
