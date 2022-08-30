<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserAccountController extends AbstractController
{
    #[Route('/user/login', name: 'user_account_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        if ($this->getUser() === null) {
            $error = $utils->getLastAuthenticationError();
            $email = $utils->getLastUsername();
            
            return $this->render('user/account/login.html.twig', [
                'hasError' => $error !== null,
                'email' => $email
            ]);

        }else {
            return $this->redirectToRoute('user');
        }
    }
    #[Route('/user/logout', name: 'user_account_logout')]
    public function logout()
    {
        
    }
}
