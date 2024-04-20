<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Matiere::class, inversedBy: 'competences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matiere $matiere = null;


    #[ORM\Column(nullable: true)]
    private ?array $lesAssistants = null;

    #[ORM\Column(length: 100)]
    private ?string $sous_matiere = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }


    public function getLesAssistants(): ?array
    {
        return $this->lesAssistants;
    }

    public function setLesAssistants(?array $lesAssistants): static
    {
        $this->lesAssistants = $lesAssistants;

        return $this;
    }

    public function getSousMatiere(): ?string
    {
        return $this->sous_matiere;
    }

    public function setSousMatiere(string $sous_matiere): static
    {
        $this->sous_matiere = $sous_matiere;

        return $this;
    }

    public function addAssistants(?array $lesAssistants): static
    {
        if ($lesAssistants !== null) {
            foreach ($lesAssistants as $assistant) {
                $this->lesAssistants[] = $assistant;
            }
        }

        return $this;
    }



}
