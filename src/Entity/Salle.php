<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $code_salle = null;

    #[ORM\OneToMany(mappedBy: 'salle', targetEntity: Soutien::class)]
    private Collection $soutien;

    public function __construct()
    {
        $this->soutien = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeSalle(): ?string
    {
        return $this->code_salle;
    }

    public function setCodeSalle(string $code_salle): static
    {
        $this->code_salle = $code_salle;

        return $this;
    }

    /**
     * @return Collection<int, Soutien>
     */
    public function getSoutien(): Collection
    {
        return $this->soutien;
    }

    public function addSoutien(Soutien $soutien): static
    {
        if (!$this->soutien->contains($soutien)) {
            $this->soutien->add($soutien);
            $soutien->setSalle($this);
        }

        return $this;
    }

    public function removeSoutien(Soutien $soutien): static
    {
        if ($this->soutien->removeElement($soutien)) {
            // set the owning side to null (unless already changed)
            if ($soutien->getSalle() === $this) {
                $soutien->setSalle(null);
            }
        }

        return $this;
    }
}
