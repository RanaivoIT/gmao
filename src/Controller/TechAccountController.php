<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TechAccountController extends AbstractController
{
    #[Route('/tech/login', name: 'tech_account_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $email = $utils->getLastUsername();
        
        return $this->render('tech/account/login.html.twig', [
            'hasError' => $error !== null,
            'email' => $email
        ]);
    }
    #[Route('/tech/logout', name: 'tech_account_logout')]
    public function logout()
    {
        
    }
}
