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

class AdminLocalisationController extends AbstractController
{
    
    #[Route('/admin/localisations', name: 'admin_localisation')]
    public function index(LocalisationRepository $localisationrepo): Response
    {

        $localisations = $localisationrepo->findall();

        return $this->render('admin/localisation/index.html.twig', [
            'title' => 'Admin - Localisation',
            'localisations' => $localisations
        ]);
    }

    #[Route('/admin/localisations/add', name: 'admin_localisation_add')]
    public function add(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $localisation = new Localisation();

        $form = $this->createForm(LocalisationType::class, $localisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $localisation->setCreatedAt(new DateTime());

            $manager->persist($localisation);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau localisation <strong>'" . $localisation->getEquipement()->getName() . ", " . $localisation->getSite()->getName() . "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('admin_localisation_show', [
                'id' => $localisation->getId()
            ]);
        }

        return $this->render('admin/localisation/add.html.twig', [
            'title' => 'Admin - Localisation',
            'localisation' => $localisation,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/localisations/{id}', name: 'admin_localisation_show')]
    public function show(Localisation $localisation): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('admin/localisation/show.html.twig', [
            'title' => 'Admin - Localisation',
            'localisation' => $localisation,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/admin/localisations/{id}/edit', name: 'admin_localisation_edit')]
    public function edit(Localisation $localisation, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(LocalisationType::class, $localisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($localisation);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les informations du localisation <strong>'" . $localisation->getEquipement()->getName() . ", " . $localisation->getSite()->getName() . "'</strong> ont été modifiés !!!"
            );

            return $this->redirectToRoute('admin_localisation_show', [
                'id' => $localisation->getId()
            ]);
        }

        return $this->render('admin/localisation/edit.html.twig', [
            'title' => 'Admin - Localisation',
            'localisation' => $localisation,
            'form' => $form->createView()
        ]);
    }



}
