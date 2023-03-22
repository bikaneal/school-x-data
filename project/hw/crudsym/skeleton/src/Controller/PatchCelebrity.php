<?php

namespace App\Controller;

use App\Entity\Celebrity\Celebrity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class PatchCelebrity extends AbstractController
{
    public function __invoke(Request $request, Celebrity $celeb, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $celeb->setName($data['name']);
        }

        if (isset($data['surname'])) {
            $celeb->setSurname($data['surname']);
        }

        if (isset($data['income'])) {
            $celeb->setIncome($data['income']);
        }

        $em->persist($celeb);
        $em->flush();

        return $this->json($celeb);
    }
}
