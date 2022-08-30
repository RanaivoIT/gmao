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

class TechUserController extends AbstractController
{
    
    #[Route('/tech/users', name: 'tech_user')]
    public function index(UserRepository $userrepo): Response
    {

        $users = $userrepo->findall();

        return $this->render('tech/user/index.html.twig', [
            'title' => 'Tech - User',
            'users' => $users
        ]);
    }

    #[Route('/tech/users/add', name: 'tech_user_add')]
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

            return $this->redirectToRoute('tech_user_show', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('tech/user/add.html.twig', [
            'title' => 'Tech - User',
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/tech/users/{id}', name: 'tech_user_show')]
    public function show(User $user): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('tech/user/show.html.twig', [
            'title' => 'Tech - User',
            'user' => $user,
            'pictures_directory' => $pictures_url
        ]);
    }

}
