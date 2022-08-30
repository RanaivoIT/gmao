<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechDashboardController extends AbstractController
{
    #[Route('/tech', name: 'tech')]
    public function index(): Response
    {
        return $this->render('tech/dashboard/index.html.twig', [
            'title' => 'Technicien',
        ]);
    }
}
