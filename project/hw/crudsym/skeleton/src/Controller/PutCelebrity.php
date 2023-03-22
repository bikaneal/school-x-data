<?php

namespace App\Controller;

use App\Entity\Celebrity\Celebrity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class PutCelebrity extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $em, Celebrity $celeb): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $celeb->setName($data['name']);
        $celeb->setSurname($data['surname']);
        $celeb->setIncome($data['income']);

        $em->persist($celeb);
        $em->flush();

        return $this->json($celeb);
    }
}
