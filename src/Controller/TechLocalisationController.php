<?php

namespace App\Controller;

use DateTime;
use App\Form\PictureType;
use App\Entity\Localisation;
use App\Form\LocalisationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LocalisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TechLocalisationController extends AbstractController
{
    
    #[Route('/tech/localisations', name: 'tech_localisation')]
    public function index(LocalisationRepository $localisationrepo): Response
    {

        $localisations = $localisationrepo->findall();

        return $this->render('tech/localisation/index.html.twig', [
            'title' => 'Tech - Localisation',
            'localisations' => $localisations
        ]);
    }

    #[Route('/tech/localisations/{id}', name: 'tech_localisation_show')]
    public function show(Localisation $localisation): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('tech/localisation/show.html.twig', [
            'title' => 'Tech - Localisation',
            'localisation' => $localisation,
            'pictures_directory' => $pictures_url
        ]);
    }

}
