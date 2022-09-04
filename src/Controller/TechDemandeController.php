<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechDemandeController extends AbstractController
{
    #[Route('/tech/demande', name: 'tech_demande')]
    public function index(): Response
    {
        return $this->render('tech/demande/index.html.twig', [
            'controller_name' => 'TechDemandeController',
        ]);
    }
}
