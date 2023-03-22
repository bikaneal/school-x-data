<?php

namespace App\Controller;

use App\Entity\Celebrity\Celebrity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetCelebrities extends AbstractController
{
    public function __invoke(EntityManagerInterface $em): JsonResponse
    {
        $celebs = $em->getRepository(Celebrity::class)->findAll();

        return $this->json($celebs);
    }

}
