<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuperAdminAccountController extends AbstractController
{
    #[Route('/super-admin/login', name: 'super_admin_account_login')]
    public function login(): Response
    {
        return $this->render('admin/account/login.html.twig', [
            'controller_name' => 'AdminAccountController',
        ]);
    }
    #[Route('/super-admin/logout', name: 'super_admin_account_logout')]
    public function logout()
    {
        
    }

}
