<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDemandeController extends AbstractController
{
    #[Route('/user/demandes', name: 'user_demande')]
    public function index(): Response
    {
        return $this->render('user/demande/index.html.twig', [
            'controller_name' => 'UserDemandeController',
        ]);
    }
}
