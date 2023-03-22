<?php

namespace App\Controller;

use App\Entity\Celebrity\Celebrity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class DeleteCelebrity extends AbstractController
{
    public function __invoke(Celebrity $celeb, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($celeb);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
