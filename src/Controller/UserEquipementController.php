<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Localisation;
use App\Repository\LocalisationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserEquipementController extends AbstractController
{
    #[Route('/user/equipements', name: 'user_equipement')]
    public function index(LocalisationRepository $repo): Response
    {
        $user = $this->getUser();
        $localisations = $repo->findBySite($user->getSite());
        return $this->render('user/equipement/index.html.twig', [
            'title' => 'Utilisateur',
            'localisations' => $localisations
        ]);
    }

    #[Route('/user/equipements/{id}', name: 'user_equipement_show')]
    public function show(Localisation $localisation): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('user/equipement/show.html.twig', [
            'title' => 'Utilisateur',
            'localisation' => $localisation,
            'pictures_directory' => $pictures_url
        ]);
    }


    
}
