<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\CountPersonBuildController;
use App\Controller\getByNomBuildController;
use App\Controller\getNbPersonBuildController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;


#[ORM\Entity(repositoryClass: BuildingRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=>['read:Building:collection','read:Building:item','read:piece']],
    paginationItemsPerPage:5,
    paginationMaximumItemsPerPage:5,
    paginationClientItemsPerPage:true,
    collectionOperations:[
        'get' => [
            'output_formats'=> [
                'json' => ['application/json']
            ],
            'openapi_context'=>[
                'summary'=> 'récupérer la liste de building',]
            ],
            'getByNomBuilding'=>[
                'method'=>'GET',
                'path'=>'building/{nomBuilding}',
                'controller'=>getByNomBuildController::class,
                'read'=>false,
                'output_formats'=> [
                    'json' => ['application/json']
                ],
                'openapi_context'=>[
                    'summary'=> 'récupérer les informations d\'un building',
                    'parameters'=>[
                        [
                            'name'=>'nomBuilding',
                            'in'=>'path',
                            'description'=>'le nom du building',
                            'type'=>'string',
                            'required'=>true,
                            'example'=>'Building n°1'
                        ]
                        
                    ],
                ]
                ],
                'getNbPersonBuild'=>[
                    'method'=>'GET',
                    'path'=>'building/{nomBuilding}/NbPersonBuild',
                    'controller'=>getNbPersonBuildController::class,
                    'read'=>false,
                    'output_formats'=> [
                        'json' => ['application/json']
                    ],
                    'openapi_context'=>[
                        'summary'=> 'Donne le nombre de personnes par building',
                        'parameters'=>[
                            [
                                'name'=>'nomBuilding',
                                'in'=>'path',
                                'description'=>'le nom du building',
                                'type'=>'string',
                                'required'=>true,
                                'example'=>'Building n°1'
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
            'output_formats'=> [
                'json' => ['application/json']
            ],
            'openapi_context'=>[
                'summary'=> 'récupérer un building avec son id',]
            ],
       
        ]
)]
class Building
{
    /* id du building**/
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Building:collection','read:building'])]
    private $id;

    /* nom du building 
     * ne peut pas être vide
    **/
    #[ORM\Column(type: 'string', length: 255)]
    #[
        Groups(['read:Building:collection','read:building','write:building']),
        Length(min:3)
    ]
    private $nomBuilding;

    /** zip code du building 
     * ne peut pas être vide
    */
    #[ORM\Column(type: 'integer')]
    #[
        Groups(['read:Building:collection','write:building']),
        Length(min:6,max:6)
    ]
    private $zipCodeBuilding;

    /**les différentes pièces du building */
    #[ORM\OneToMany(mappedBy: 'building', targetEntity: Piece::class)]
    #[Groups(['read:Building:item'])]
    private $pieces;

    /* Les différentes fonctions get et set **/

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
