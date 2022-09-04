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

class UserDemandeController extends AbstractController
{
    #[Route('/user/demandes', name: 'user_demande')]
    public function index(DemandeRepository $demanderepo): Response
    {

        $demandes = $demanderepo->findBySite($this->getUser()->getSite());

        return $this->render('user/demande/index.html.twig', [
            'title' => 'Admin - Demande',
            'demandes' => $demandes
        ]);
    }

    #[Route('/user/demandes/add/{id}', name: 'user_demande_add')]
    public function add(Localisation $localisation,  Request $request, EntityManagerInterface $manager): Response
    {
        $demande = new Demande();
        $demande->setLocalisation($localisation);
        
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $demande->setCreatedAt(new DateTime());

            $manager->persist($demande);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau demande <strong>'" . $demande->getEquipement()->getName() . ", " . $demande->getSite()->getName() . "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('user_demande_show', [
                'id' => $demande->getId()
            ]);
        }

        return $this->render('user/demande/add.html.twig', [
            'title' => 'Admin - Demande',
            'demande' => $demande,
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/demandes/{id}', name: 'user_demande_show')]
    public function show(Demande $demande): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('user/demande/show.html.twig', [
            'title' => 'Utilisateur',
            'demande' => $demande,
            'pictures_directory' => $pictures_url
        ]);
    }

}
