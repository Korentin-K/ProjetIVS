<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\getByNomPieceController;
use App\Controller\getNbPersonPieceController;
use App\Repository\PieceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:Piece:collection']],
    paginationItemsPerPage:5,
    paginationMaximumItemsPerPage:5,
    paginationClientItemsPerPage:true,
    collectionOperations: [
        'get' => [
            'normalization_context'=> ['groups' => ['read:Piece:collection','read:Piece:item','read:building']],
            'output_formats'=> [
                'json' => ['application/json']
            ],
            'openapi_context'=>[
                'summary'=> 'récupérer la liste des pieces',]
            
            ],
            'getByNomPiece'=>[
                'method'=>'GET',
                'path'=>'piece/{nomPiece}',
                'controller'=>getByNomPieceController::class,
                'read'=>false,
                'output_formats'=> [
                    'json' => ['application/json']
                ],
                'openapi_context'=>[
                    'summary'=> 'récupérer les informations d\'une pièce',
                    'parameters'=>[
                        [
                            'name'=>'nomPiece',
                            'in'=>'path',
                            'description'=>'le nom de la pièce',
                            'type'=>'string',
                            'required'=>true,
                            'example'=>'Pièce n°1'
                        ]
                    ],
                ]
                ],
                'getNbPersonPiece'=>[
                    'method'=>'GET',
                    'path'=>'piece/{nomPiece}/nbPerson',
                    'controller'=>getNbPersonPieceController::class,
                    'read'=>false,
                    'output_formats'=> [
                        'json' => ['application/json']
                    ],
                    'openapi_context'=>[
                        'summary'=> 'récupérer le nombre de personnes dans une pièce',
                        'parameters'=>[
                            [
                                'name'=>'nomPiece',
                                'in'=>'path',
                                'description'=>'le nom de la pièce',
                                'type'=>'string',
                                'required'=>true,
                                'example'=>'Pièce n°1'
                            ]
                        ],'responses'=>[
                            '200'=>[
                                'description'=> 'OK',
                                'content'=>[
                                    'application/json'=>[
                                        'schema'=>[
                                            'name'=>'nombre de personne',
                                            'type'=>'integer',
                                            'example'=>3
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
    ],
    itemOperations: [
        'get' => [
            'normalization_context'=> ['groups' => ['read:Piece:collection','read:Piece:item','read:building']],
            'output_formats'=> [
                'json' => ['application/json']
            ],
            'openapi_context'=>[
                'summary'=> 'récupérer une pièce avec son id',]
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
    #[
        Groups(['read:Piece:collection','read:piece']),
        Length(min:3)
    ]
    private $nbPersonnePiece;

    /** lien vers le building */
    #[ORM\ManyToOne(targetEntity: Building::class, inversedBy: 'pieces')]
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
