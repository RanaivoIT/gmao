<?php

namespace App\Controller;

use DateTime;
use App\Entity\Demande;
use App\Form\PictureType;
use App\Entity\Intervention;
use App\Form\InterventionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminInterventionController extends AbstractController
{
    
    #[Route('/admin/interventions', name: 'admin_intervention')]
    public function index(InterventionRepository $interventionrepo): Response
    {
        $interventions = $interventionrepo->findall();

        return $this->render('admin/intervention/index.html.twig', [
            'title' => 'Admin - Intervention',
            'interventions' => $interventions
        ]);
    }

    #[Route('/admin/interventions/add/{id}', name: 'admin_intervention_add')]
    public function add(Demande $demande, Request $request, EntityManagerInterface $manager): Response
    {
        $intervention = new Intervention();
        $intervention->setcreatedAt(new DateTime());
        $intervention->setDemande($demande);
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $intervention->setCreatedAt(new DateTime());

            $manager->persist($intervention);
            $manager->flush();

            $this->addFlash(
                'success',
                "La nouvelle intervention <strong>'" . $intervention->getDemande()->getLocalisation()->getEquipement()->getName() . ", " . $intervention->getDemande()->getLocalisation()->getSite()->getName() . "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('admin_intervention_show', [
                'id' => $intervention->getId()
            ]);
        }

        return $this->render('admin/intervention/add.html.twig', [
            'title' => 'Admin - Intervention',
            'intervention' => $intervention,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/interventions/{id}', name: 'admin_intervention_show')]
    public function show(Intervention $intervention): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('admin/intervention/show.html.twig', [
            'title' => 'Admin - Intervention',
            'intervention' => $intervention,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/admin/interventions/{id}/edit', name: 'admin_intervention_edit')]
    public function edit(Intervention $intervention, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($intervention);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les informations du intervention <strong>'" . $intervention->getEquipement()->getName() . ", " . $intervention->getSite()->getName() . "'</strong> ont été modifiés !!!"
            );

            return $this->redirectToRoute('admin_intervention_show', [
                'id' => $intervention->getId()   
            ]);
        }

        return $this->render('admin/intervention/edit.html.twig', [
            'title' => 'Admin - Intervention',
            'intervention' => $intervention,
            'form' => $form->createView()
        ]);
    }



}
