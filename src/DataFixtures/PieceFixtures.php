<?php

namespace App\DataFixtures;

use App\Entity\Building;
use App\Entity\Piece;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PieceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $buildings=$manager->getRepository(Building::class)->findAll();
        foreach($buildings as $building)
        {
            for ($i = 1; $i < 3; ++$i){
                $piece= new Piece;
                $piece->setNomPiece('piece n°'.$i);
                $piece->setNbPersonnePiece(2*$i);
                $piece->setBuilding($building);
                $manager->persist($piece);
            }
            $manager->flush(); 
        }
         
        
    }
}
