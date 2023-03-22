<?php

namespace App\Controller;

use App\Entity\Celebrity\Celebrity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetCelebrity extends AbstractController
{
    public function __invoke(Celebrity $celeb): JsonResponse
    {
        return $this->json($celeb);
    }

}
