<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin_demande = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'demandes')]
    #[ORM\JoinColumn(name: 'id_user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $id_user = null;

    #[ORM\ManyToOne(targetEntity: Matiere::class)]
    #[ORM\JoinColumn(name: "matiere_id", referencedColumnName: "id")]
    #[Assert\NotBlank]
    private ?Matiere $id_matiere = null;

    #[ORM\Column]
    private ?int $status = null;


    #[Assert\NotBlank]
    #[ORM\Column(length: 50)]
    private ?string $sousMatiere = null;


    #[ORM\ManyToOne(inversedBy: 'demandes')]
    private ?User $assistant = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateFinDemande(): ?\DateTimeInterface
    {
        return $this->date_fin_demande;
    }

    public function setDateFinDemande(\DateTimeInterface $date_fin_demande): static
    {
        $this->date_fin_demande = $date_fin_demande;

        return $this;
    }


    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdMatiere(): ?Matiere
    {
        return $this->id_matiere;
    }

    public function setIdMatiere(?Matiere $id_matiere): static
    {
        $this->id_matiere = $id_matiere;

        return $this;
    }

    public function getStatus(): ?int
    {

        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSousMatiere(): ?string
    {
        return $this->sousMatiere;
    }

    public function setSousMatiere(string $sousMatiere): static
    {
        $this->sousMatiere = $sousMatiere;

        return $this;
    }


    public function getAssistant(): ?User
    {
        return $this->assistant;
    }

    public function setAssistant(?User $assistant): static
    {
        $this->assistant = $assistant;

        return $this;
    }

}
