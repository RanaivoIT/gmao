<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\PictureType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserUserController extends AbstractController
{
    #[Route('/user/users', name: 'user_user')]
    public function index(UserRepository $repo): Response
    {
        $users = $repo->findBySite($this->getUser()->getSite());
        return $this->render('user/user/index.html.twig', [
            'title' => 'Utilisateur',
            'users' => $users
        ]);
    }

    #[Route('/user/users/{id}', name: 'user_user_show')]
    public function show(User $user): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('user/user/show.html.twig', [
            'title' => 'Utilisateur',
            'user' => $user,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/user/users/{id}/edit', name: 'user_user_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if ($user->getId() === $this->getUser()->getId()) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                    
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Les informations de l'utilisateur <strong>'" . $user->getFirstname() . ", " . $user->getLastname() . "'</strong> ont été modifiés !!!"
                );

                return $this->redirectToRoute('user_user_show', [
                    'id' => $user->getId()
                ]);
            }

            return $this->render('user/user/edit.html.twig', [
                'title' => 'Admin - User',
                'user' => $user,
                'form' => $form->createView()
            ]);
        }else {
            return $this->redirectToRoute('user_user');
        }
        
    }

    #[Route('/user/users/{id}/change-avatar', name: 'user_user_avatar')]
    public function change_avatar(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if ($user->getId() === $this->getUser()->getId()) {
            $form = $this->createForm(PictureType::class, null);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                
                $picture =  $form->get('picture')->getData();

                if ($picture) {
                    $filename = "user" . $user->getId() . "." . $picture->guessExtension();
                    try {
                        $picture->move(
                            $this->getParameter('pictures_directory'),
                            $filename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
                    $user->setAvatar($filename);
                }

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "L'avatar de l'utilisateur <strong>'" . $user->getFirstname() . ", " . $user->getLastname() . "'</strong> a été modifiée !!!"
                );

                return $this->redirectToRoute('user_user_show', [
                    'id' => $user->getId()
                ]);
            }

            return $this->render('user/user/avatar.html.twig', [
                'title' => 'Admin - User',
                'user' => $user,
                'form' => $form->createView()
            ]);
        }else {
            return $this->redirectToRoute('user_user');
        }
        
    }


}
