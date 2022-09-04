<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechInterventionController extends AbstractController
{
    #[Route('/tech/intervention', name: 'tech_intervention')]
    public function index(): Response
    {
        return $this->render('tech/intervention/index.html.twig', [
            'controller_name' => 'TechInterventionController',
        ]);
    }
}
