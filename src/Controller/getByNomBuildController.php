<?php

namespace App\Controller;

use App\Entity\Building;
use App\Repository\BuildingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;

#[AsController]
class getByNomBuildController extends AbstractController
{
    public function __construct(private BuildingRepository $buildingRepository)
    {
        
    }
    public function __invoke(string $nomBuilding)
    {
        $Building=$this->buildingRepository->findBy(
                ['nomBuilding'=>$nomBuilding]
            );
            /**sert à gérer si le building n'existe pas */
        if(!$nomBuilding){
            throw $this->createNotFoundException(
                'pas de building avec ce nom'
            );
        }
        return $Building;    
    }
}