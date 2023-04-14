<?php

namespace App\Controller;

use ApiPlatform\OpenApi\Model\Response;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
final class CreateImageController extends AbstractController
{

    public function __construct(
        private Security $security
    ){
        $this->security = $security;
    }

    public function __invoke(Request $request): Image
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $picture = new Image();
        $picture->file = $uploadedFile;

        return $picture;
    }

    public function index(User $user, EntityManagerInterface $em): Response
    {
        $pic = new Image();
        $pic->$user = $this->security->getUser();
        $pic->setUser($pic->$user);
        
        $em->persist($pic);
        $em->flush();

        return new Response('Saved new user with id '.$pic->getId());
    }    
}