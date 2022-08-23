<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAccountController extends AbstractController
{
    #[Route('/user/login', name: 'user_account_login')]
    public function login(): Response
    {
        return $this->render('user/account/login.html.twig', [
            
        ]);
    }
    #[Route('/user/logout', name: 'user_account_logout')]
    public function logout()
    {
        
    }
}
