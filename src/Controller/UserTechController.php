<?php

namespace App\Controller;

use App\Entity\Tech;
use App\Repository\TechRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserTechController extends AbstractController
{
    #[Route('/user/techs', name: 'user_tech')]
    public function index(TechRepository $repo): Response
    {
        $techs = $repo->findAll();
        return $this->render('user/tech/index.html.twig', [
            'title' => 'Utilisateur',
            'techs' => $techs
        ]);
    }

    #[Route('/user/techs/{id}', name: 'user_tech_show')]
    public function show(Tech $tech): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('user/tech/show.html.twig', [
            'title' => 'Utilisateur',
            'tech' => $tech,
            'pictures_directory' => $pictures_url
        ]);
    }

}
