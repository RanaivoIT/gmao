<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechAccountController extends AbstractController
{
    #[Route('/tech/login', name: 'tech_account_login')]
    public function login(): Response
    {
        return $this->render('tech/account/login.html.twig', [
            
        ]);
    }
    #[Route('/tech/logout', name: 'tech_account_logout')]
    public function logout()
    {
        
    }
}
