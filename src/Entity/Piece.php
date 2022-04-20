<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PieceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
#[ApiResource(
    collectionOperations: ['get','post'],
    itemOperations:[]
)]
class Piece
{
    /**id de la pièce */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Assert\id]
    private $id;

    /** nom de la pièce */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $nomPiece;

    /** nombre de personne dans la pièce */
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private $nbPersonnePiece;

    /** lien vers le building */
    #[ORM\ManyToOne(targetEntity: Building::class, inversedBy: 'pieces')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private $building;

    /* Les différentes fonctions get et set **/
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
