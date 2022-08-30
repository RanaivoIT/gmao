<?php

namespace App\Controller;

use App\Entity\Organe;
use App\Form\OrganeType;
use App\Form\PictureType;
use App\Entity\Equipement;
use App\Form\EquipementType;
use App\Repository\EquipementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TechEquipementController extends AbstractController
{
    
    #[Route('/tech/equipements', name: 'tech_equipement')]
    public function index(EquipementRepository $equipementrepo): Response
    {

        $equipements = $equipementrepo->findall();

        return $this->render('tech/equipement/index.html.twig', [
            'title' => 'Tech - Equipement',
            'equipements' => $equipements
        ]);
    }

    #[Route('/tech/equipements/add', name: 'tech_equipement_add')]
    public function add(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $equipement = new Equipement();

        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            foreach ($equipement->getOrganes() as $organe) {
                $organe->setEquipement($equipement);
                $manager->persist($organe);
            }

            $equipement
                ->setPicture('equipement.jpg');
                
            $manager->persist($equipement);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau equipement <strong>'" . $equipement->getName(). "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('tech_equipement_show', [
                'id' => $equipement->getId()
            ]);
        }

        return $this->render('tech/equipement/add.html.twig', [
            'title' => 'Tech - Equipement',
            'equipement' => $equipement,
            'form' => $form->createView()
        ]);
    }

    #[Route('/tech/equipements/{id}', name: 'tech_equipement_show')]
    public function show(Equipement $equipement): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('tech/equipement/show.html.twig', [
            'title' => 'Tech - Equipement',
            'equipement' => $equipement,
            'pictures_directory' => $pictures_url
        ]);
    }
    

}
