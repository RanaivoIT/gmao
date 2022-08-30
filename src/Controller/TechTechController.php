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

class TechTechController extends AbstractController
{
    
    #[Route('/tech/techs', name: 'tech_tech')]
    public function index(TechRepository $techrepo): Response
    {

        $techs = $techrepo->findall();

        return $this->render('tech/tech/index.html.twig', [
            'title' => 'Tech - Tech',
            'techs' => $techs
        ]);
    }

    

    #[Route('/tech/techs/{id}', name: 'tech_tech_show')]
    public function show(Tech $tech): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('tech/tech/show.html.twig', [
            'title' => 'Tech - Tech',
            'tech' => $tech,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/tech/techs/{id}/edit', name: 'tech_tech_edit')]
    public function edit(Tech $tech, Request $request, EntityManagerInterface $manager): Response
    {
        if ($user->getId() === $this->getUser()->getId()) {
            $form = $this->createForm(TechType::class, $tech);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                    
                $manager->persist($tech);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Les informations du technicien <strong>'" . $tech->getFirstname() . ", " . $tech->getLastname() . "'</strong> ont été modifiés !!!"
                );

                return $this->redirectToRoute('tech_tech_show', [
                    'id' => $tech->getId()
                ]);
            }

            return $this->render('tech/tech/edit.html.twig', [
                'title' => 'Tech - Tech',
                'tech' => $tech,
                'form' => $form->createView()
            ]);
        }else {
            return $this->redirectToRoute('tech_tech');
        }
    }

    #[Route('/tech/techs/{id}/change-avatar', name: 'tech_tech_avatar')]
    public function change_avatar(Tech $tech, Request $request, EntityManagerInterface $manager): Response
    {
        if ($user->getId() === $this->getUser()->getId()) {
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

                return $this->redirectToRoute('tech_tech_show', [
                    'id' => $tech->getId()
                ]);
            }

            return $this->render('tech/tech/avatar.html.twig', [
                'title' => 'Tech - Tech',
                'tech' => $tech,
                'form' => $form->createView()
            ]);
        }else {
            return $this->redirectToRoute('tech_tech');
        }
    }

}
