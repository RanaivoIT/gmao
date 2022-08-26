<?php

namespace App\Controller;

use App\Entity\Tech;
use App\Form\TechType;
use App\Form\PictureType;
use App\Repository\TechRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminTechController extends AbstractController
{
    
    #[Route('/admin/techs', name: 'admin_tech')]
    public function index(TechRepository $techrepo): Response
    {

        $techs = $techrepo->findall();

        return $this->render('admin/tech/index.html.twig', [
            'title' => 'Admin - Tech',
            'techs' => $techs
        ]);
    }

    #[Route('/admin/techs/add', name: 'admin_tech_add')]
    public function add(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $tech = new Tech();
        $form = $this->createForm(TechType::class, $tech);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $tech
                ->setHash($encoder->hashPassword($tech, "password"))
                ->setRoles(['ROLE_TECH'])
                ->setAvatar('/img/avatar.png');
                
            $manager->persist($tech);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau technicien <strong>'" . $tech->getFirstname() . ", " . $tech->getLastname() . "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('admin_tech_show', [
                'id' => $tech->getId()
            ]);
        }

        return $this->render('admin/tech/add.html.twig', [
            'title' => 'Admin - Tech',
            'tech' => $tech,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/techs/{id}', name: 'admin_tech_show')]
    public function show(Tech $tech): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('admin/tech/show.html.twig', [
            'title' => 'Admin - Tech',
            'tech' => $tech,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/admin/techs/{id}/edit', name: 'admin_tech_edit')]
    public function edit(Tech $tech, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(TechType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                
            $manager->persist($tech);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les informations du technicien <strong>'" . $tech->getFirstname() . ", " . $tech->getLastname() . "'</strong> ont été modifiés !!!"
            );

            return $this->redirectToRoute('admin_tech_show', [
                'id' => $tech->getId()
            ]);
        }

        return $this->render('admin/tech/edit.html.twig', [
            'title' => 'Admin - Tech',
            'tech' => $tech,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/techs/{id}/change-avatar', name: 'admin_tech_avatar')]
    public function change_avatar(Tech $tech, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PictureType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $picture =  $form->get('picture')->getData();

            if ($picture) {
                $filename = "tech" . $tech->getId() . "." . $picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('pictures_directory'),
                        $filename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $tech->setAvatar($filename);
            }

            $manager->persist($tech);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'avatar du technicien <strong>'" . $tech->getFirstname() . ", " . $tech->getLastname() . "'</strong> a été modifiée !!!"
            );

            return $this->redirectToRoute('admin_tech_show', [
                'id' => $tech->getId()
            ]);
        }

        return $this->render('admin/tech/avatar.html.twig', [
            'title' => 'Admin - Tech',
            'tech' => $tech,
            'form' => $form->createView()
        ]);
    }

}
