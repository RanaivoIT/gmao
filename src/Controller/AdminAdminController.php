<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Form\PictureType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminAdminController extends AbstractController
{
    
    #[Route('/admin/admins', name: 'admin_admin')]
    public function index(AdminRepository $adminrepo): Response
    {

        $admins = $adminrepo->findall();

        return $this->render('admin/admin/index.html.twig', [
            'title' => 'Admin - Admin',
            'admins' => $admins
        ]);
    }

    #[Route('/admin/admins/add', name: 'admin_admin_add')]
    public function add(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $admin
                ->setHash($encoder->hashPassword($admin, "password"))
                ->setRoles(['ROLE_ADMIN'])
                ->setAvatar('avatar.png');
                
            $manager->persist($admin);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau administrateur <strong>'" . $admin->getFirstname() . ", " . $admin->getLastname() . "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('admin_admin_show', [
                'id' => $admin->getId()
            ]);
        }

        return $this->render('admin/admin/add.html.twig', [
            'title' => 'Admin - Admin',
            'admin' => $admin,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/admins/{id}', name: 'admin_admin_show')]
    public function show(Admin $admin): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('admin/admin/show.html.twig', [
            'title' => 'Admin - Admin',
            'admin' => $admin,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/admin/admins/{id}/edit', name: 'admin_admin_edit')]
    public function edit(Admin $admin, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                
            $manager->persist($admin);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les informations du administrateur <strong>'" . $admin->getFirstname() . ", " . $admin->getLastname() . "'</strong> ont été modifiés !!!"
            );

            return $this->redirectToRoute('admin_admin_show', [
                'id' => $admin->getId()
            ]);
        }

        return $this->render('admin/admin/edit.html.twig', [
            'title' => 'Admin - Admin',
            'admin' => $admin,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/admins/{id}/change-avatar', name: 'admin_admin_avatar')]
    public function change_avatar(Admin $admin, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PictureType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $picture =  $form->get('picture')->getData();

            if ($picture) {
                $filename = "admin" . $admin->getId() . "." . $picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('pictures_directory'),
                        $filename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $admin->setAvatar($filename);
            }

            $manager->persist($admin);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'avatar du administrateur <strong>'" . $admin->getFirstname() . ", " . $admin->getLastname() . "'</strong> a été modifiée !!!"
            );

            return $this->redirectToRoute('admin_admin_show', [
                'id' => $admin->getId()
            ]);
        }

        return $this->render('admin/admin/avatar.html.twig', [
            'title' => 'Admin - Admin',
            'admin' => $admin,
            'form' => $form->createView()
        ]);
    }

}
