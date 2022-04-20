<?php

namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomPiece;

    #[ORM\Column(type: 'integer')]
    private $nbPersonnePiece;

    #[ORM\ManyToOne(targetEntity: Building::class, inversedBy: 'pieces')]
    #[ORM\JoinColumn(nullable: false)]
    private $building;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPiece(): ?string
    {
        return $this->nomPiece;
    }

    public function setNomPiece(string $nomPiece): self
    {
        $this->nomPiece = $nomPiece;

        return $this;
    }

    public function getNbPersonnePiece(): ?int
    {
        return $this->nbPersonnePiece;
    }

    public function setNbPersonnePiece(int $nbPersonnePiece): self
    {
        $this->nbPersonnePiece = $nbPersonnePiece;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }
}
