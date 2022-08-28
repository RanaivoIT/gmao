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

class AdminEquipementController extends AbstractController
{
    
    #[Route('/admin/equipements', name: 'admin_equipement')]
    public function index(EquipementRepository $equipementrepo): Response
    {

        $equipements = $equipementrepo->findall();

        return $this->render('admin/equipement/index.html.twig', [
            'title' => 'Admin - Equipement',
            'equipements' => $equipements
        ]);
    }

    #[Route('/admin/equipements/add', name: 'admin_equipement_add')]
    public function add(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $equipement = new Equipement();

        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            foreach ($equipement->getServices() as $service) {
                $service->setEquipement($equipement);
                $manager->persist($service);
            }

            $equipement
                ->setPicture('equipement.jpg');
                
            $manager->persist($equipement);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau equipement <strong>'" . $equipement->getName(). "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('admin_equipement_show', [
                'id' => $equipement->getId()
            ]);
        }

        return $this->render('admin/equipement/add.html.twig', [
            'title' => 'Admin - Equipement',
            'equipement' => $equipement,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/equipements/{id}', name: 'admin_equipement_show')]
    public function show(Equipement $equipement): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('admin/equipement/show.html.twig', [
            'title' => 'Admin - Equipement',
            'equipement' => $equipement,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/admin/equipements/{id}/edit', name: 'admin_equipement_edit')]
    public function edit(Equipement $equipement, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($equipement);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les informations de l'equipement <strong>'" . $equipement->getName() . "'</strong> ont été modifiés !!!"
            );

            return $this->redirectToRoute('admin_equipement_show', [
                'id' => $equipement->getId()
            ]);
        }

        return $this->render('admin/equipement/edit.html.twig', [
            'title' => 'Admin - Equipement',
            'equipement' => $equipement,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/equipements/organes/{id}', name: 'admin_equipement_organe_edit')]
    public function edit_organe(Organe $organe, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(OrganeType::class, $organe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($organe->getPieces() as $piece) {
                $piece->setOrgane($organe);
                $manager->persist($piece);
            }

            $manager->persist($organe);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'organe <strong>'" . $organe->getName() . "'</strong> a été modifié !!!"
            );

            return $this->redirectToRoute('admin_equipement_show', [
                'id' => $organe->getEquipement()->getId()
            ]);
        }

        return $this->render('admin/equipement/edit.organe.html.twig', [
            'title' => 'Admin - Organe',
            'organe' => $organe,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/equipements/{id}/change-picture', name: 'admin_equipement_picture')]
    public function change_picture(Equipement $equipement, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PictureType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $picture =  $form->get('picture')->getData();

            if ($picture) {
                $filename = "equipement" . $equipement->getId() . "." . $picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('pictures_directory'),
                        $filename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $equipement->setPicture($filename);
            }

            $manager->persist($equipement);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'image du equipement <strong>'" . $equipement->getName() . "'</strong> a été modifiée !!!"
            );

            return $this->redirectToRoute('admin_equipement_show', [
                'id' => $equipement->getId()
            ]);
        }

        return $this->render('admin/equipement/picture.html.twig', [
            'title' => 'Admin - Equipement',
            'equipement' => $equipement,
            'form' => $form->createView()
        ]);
    }

}
