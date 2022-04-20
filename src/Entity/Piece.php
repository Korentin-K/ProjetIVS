<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PieceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:Piece:collection']],
    collectionOperations: [
        'get' => [
            'normalization_context'=> ['groups' => ['read:Piece:collection','read:Piece:item','read:building']],
            'output_formats'=> [
                'json' => ['application/json']
            ]
        ]
    ],
    itemOperations: [
        'get' => [
            'normalization_context'=> ['groups' => ['read:Piece:collection','read:Piece:item','read:building']],
            'output_formats'=> [
                'json' => ['application/json']
            ]
        ]
    ]
    
)]
class Piece
{
    /**id de la pièce */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:piece','read:Piece:collection'])]
    private $id;

    /** nom de la pièce */
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:piece','read:Piece:collection'])]
    private $nomPiece;

    /** nombre de personne dans la pièce */
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Piece:collection'])]
    private $nbPersonnePiece;

    /** lien vers le building */
    #[ORM\ManyToOne(targetEntity: Building::class, inversedBy: 'pieces')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:Piece:item'])]
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
