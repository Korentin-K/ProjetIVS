<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Repository\BuildingRepository;
use App\Repository\PieceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;

#[AsController]
class getNbPersonBuildController extends AbstractController
{
    public function __construct(private BuildingRepository $buildingRepository)
    {
        
    }

    public function __invoke(string $nomBuilding)
    {
        $pieces=$this->buildingRepository->findOneBy(['nomBuilding'=>$nomBuilding])->getPieces();
        /** création d'une variable qui stock le calcul */
        $nombrePersonne=0;
        /**on fait un foreach pour parcourir toutes les pièces obtenu et obtenir le nombre de personne */
        foreach($pieces as $piece)
        {
           $nombrePersonne=$nombrePersonne + $piece->getNbPersonnePiece();
        }
         /**sert à gérer si le building n'existe pas */
         if(!$nomBuilding){
            throw $this->createNotFoundException(
                'pas de building avec ce nom'
            );
        }
        return $this->json(
            [
                'nombre de personne'=>$nombrePersonne
            ]
            );
        /**$pieces[0]->getNbPersonnePiece();*/
    }
}