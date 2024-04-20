<?php

namespace App\Entity;

use App\Repository\SoutienRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SoutienRepository::class)]
class Soutien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_du_soutien = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'soutiens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'soutien')]
    private ?Salle $salle = null;

    #[ORM\Column(length: 255)]
    private ?string $sous_matiere = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDuSoutien(): ?\DateTimeInterface
    {
        return $this->date_du_soutien;
    }

    public function setDateDuSoutien(\DateTimeInterface $date_du_soutien): static
    {
        $this->date_du_soutien = $date_du_soutien;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->date_updated;
    }

    public function setDateUpdated(\DateTimeInterface $date_updated): static
    {
        $this->date_updated = $date_updated;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
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

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): static
    {
        $this->salle = $salle;

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


}
