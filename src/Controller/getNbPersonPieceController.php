<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Repository\PieceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;

#[AsController]
class getNbPersonPieceController extends AbstractController
{
    public function __construct(private PieceRepository $pieceRepository)
    {
        
    }

    public function __invoke(string $nomPiece,string $nomBuilding)
    {
        /** sert à gérer si la pièce n'existe pas */
        if(!$nomPiece){
            throw $this->createNotFoundException(
                'pas de batiment avec ce nom'
            );
        }
        $nombreDePersonne=0;
        $nomPieceTrouve='';
        $nomBuildingTrouve='';
        $pieces=$this->pieceRepository->findBy(['nomPiece'=>$nomPiece]);
        foreach($pieces as $piece)
        {
            $building=$piece->getBuilding();
            if($building->getNomBuilding()==$nomBuilding)
            {
                $nombreDePersonne=$piece->getNbPersonnePiece();
                $nomPieceTrouve=$piece->getNomPiece();
                $nomBuildingTrouve=$building->getNomBuilding();
            }
        }
        return $this->json(
            [
                'nom du Building'=>$nomBuildingTrouve,
                'nom de la piece' => $nomPieceTrouve,
                'nombre de personne'=>$nombreDePersonne

            ]
            );
    }
}