<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuildingRepository::class)]
#[ApiResource]
class Building
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomBuilding;

    #[ORM\Column(type: 'integer')]
    private $zipCodeBuilding;

    #[ORM\OneToMany(mappedBy: 'building', targetEntity: Piece::class)]
    private $pieces;

    public function __construct()
    {
        $this->pieces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomBuilding(): ?string
    {
        return $this->nomBuilding;
    }

    public function setNomBuilding(string $nomBuilding): self
    {
        $this->nomBuilding = $nomBuilding;

        return $this;
    }

    public function getZipCodeBuilding(): ?int
    {
        return $this->zipCodeBuilding;
    }

    public function setZipCodeBuilding(int $zipCodeBuilding): self
    {
        $this->zipCodeBuilding = $zipCodeBuilding;

        return $this;
    }

    /**
     * @return Collection<int, Piece>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Piece $piece): self
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces[] = $piece;
            $piece->setBuilding($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): self
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getBuilding() === $this) {
                $piece->setBuilding(null);
            }
        }

        return $this;
    }
}
