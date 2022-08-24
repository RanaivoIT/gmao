<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SuperAdminAccountController extends AbstractController
{
    #[Route('/super-admin/login', name: 'super_admin_account_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $email = $utils->getLastUsername();
        
        return $this->render('admin/account/login.html.twig', [
            'post_path' => 'super_admin_account_login',
            'hasError' => $error !== null,
            'email' => $email
        ]);
    }
    #[Route('/super-admin/logout', name: 'super_admin_account_logout')]
    public function logout()
    {
        
    }

}
