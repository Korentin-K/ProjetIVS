<?php

namespace App\DataFixtures;

use App\Entity\Building;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BuildingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <10; ++$i){
            $building= new Building;
            $building->setNomBuilding('building'.$i);
            $building->setZipCodeBuilding(23455);
            $manager->persist($building);
        }
        $manager->flush();   
        
    }
}
