<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

class GetUserController extends AbstractController
{

    public function __construct (

        private Security $security
    ) {}

    public function __invoke () {

        $this->security->getUser();
    }
}