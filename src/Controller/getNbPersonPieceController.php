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

    public function __invoke(string $nomPiece): int
    {
        /** sert à gérer si la pièce n'existe pas */
        if(!$nomPiece){
            throw $this->createNotFoundException(
                'pas de batiment avec ce nom'
            );
        }
        return $this->pieceRepository->findOneBy(['nomPiece'=>$nomPiece])->getNbPersonnePiece();
        
    }
}