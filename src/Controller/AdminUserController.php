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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminUserController extends AbstractController
{
    
    #[Route('/admin/users', name: 'admin_user')]
    public function index(UserRepository $userrepo): Response
    {

        $users = $userrepo->findall();

        return $this->render('admin/user/index.html.twig', [
            'title' => 'Admin - User',
            'users' => $users
        ]);
    }

    #[Route('/admin/users/add', name: 'admin_user_add')]
    public function add(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user
                ->setHash($encoder->hashPassword($user, "password"))
                ->setRoles(['ROLE_USER'])
                ->setAvatar('avatar.png');
                
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau utilisateur <strong>'" . $user->getFirstname() . ", " . $user->getLastname() . "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('admin_user_show', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('admin/user/add.html.twig', [
            'title' => 'Admin - User',
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/users/{id}', name: 'admin_user_show')]
    public function show(User $user): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('admin/user/show.html.twig', [
            'title' => 'Admin - User',
            'user' => $user,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/admin/users/{id}/edit', name: 'admin_user_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les informations de l'utilisateur <strong>'" . $user->getFirstname() . ", " . $user->getLastname() . "'</strong> ont été modifiés !!!"
            );

            return $this->redirectToRoute('admin_user_show', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'title' => 'Admin - User',
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/users/{id}/change-avatar', name: 'admin_user_avatar')]
    public function change_avatar(User $user, Request $request, EntityManagerInterface $manager): Response
    {
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

            return $this->redirectToRoute('admin_user_show', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('admin/user/avatar.html.twig', [
            'title' => 'Admin - User',
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

}
