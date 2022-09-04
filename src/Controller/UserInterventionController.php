<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserInterventionController extends AbstractController
{
    #[Route('/user/intervention', name: 'app_user_intervention')]
    public function index(): Response
    {
        return $this->render('user_intervention/index.html.twig', [
            'controller_name' => 'UserInterventionController',
        ]);
    }
}
