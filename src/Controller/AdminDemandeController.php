<?php

namespace App\Controller;

use DateTime;
use App\Entity\Demande;
use App\Form\DemandeType;
use App\Entity\Localisation;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDemandeController extends AbstractController
{
    #[Route('/admin/demandes', name: 'admin_demande')]
    public function index(DemandeRepository $demanderepo): Response
    {

        $demandes = $demanderepo->findall();

        return $this->render('admin/demande/index.html.twig', [
            'title' => 'Admin - Demande',
            'demandes' => $demandes
        ]);
    }

    #[Route('/admin/demandes/{id}', name: 'admin_demande_show')]
    public function show(Demande $demande): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('admin/demande/show.html.twig', [
            'title' => 'Admin',
            'demande' => $demande,
            'pictures_directory' => $pictures_url
        ]);
    }

}
