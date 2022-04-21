<?php

namespace App\Controller;

use App\Repository\BuildingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CountPersonBuildController extends AbstractController
{
    public function __construct(private BuildingRepository $buildingRepository)
    {
        
    }
    public function __invoke() : int
    {
        return $this->buildingRepository->count([]);
    }
}