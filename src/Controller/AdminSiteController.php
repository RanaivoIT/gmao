<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use App\Form\PictureType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminSiteController extends AbstractController
{
    
    #[Route('/admin/sites', name: 'admin_site')]
    public function index(SiteRepository $siterepo): Response
    {

        $sites = $siterepo->findall();

        return $this->render('admin/site/index.html.twig', [
            'title' => 'Admin - Site',
            'sites' => $sites
        ]);
    }

    #[Route('/admin/sites/add', name: 'admin_site_add')]
    public function add(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {
        $site = new Site();

        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $site
                ->setPicture('site.jpg');
                
            $manager->persist($site);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau site <strong>'" . $site->getName(). "'</strong> est ajouté !!!"
            );

            return $this->redirectToRoute('admin_site_show', [
                'id' => $site->getId()
            ]);
        }

        return $this->render('admin/site/add.html.twig', [
            'title' => 'Admin - Site',
            'site' => $site,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/sites/{id}', name: 'admin_site_show')]
    public function show(Site $site): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('admin/site/show.html.twig', [
            'title' => 'Admin - Site',
            'site' => $site,
            'pictures_directory' => $pictures_url
        ]);
    }

    #[Route('/admin/sites/{id}/edit', name: 'admin_site_edit')]
    public function edit(Site $site, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($site);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les informations du site <strong>'" . $site->getName() . "'</strong> ont été modifiés !!!"
            );

            return $this->redirectToRoute('admin_site_show', [
                'id' => $site->getId()
            ]);
        }

        return $this->render('admin/site/edit.html.twig', [
            'title' => 'Admin - Site',
            'site' => $site,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/sites/{id}/change-picture', name: 'admin_site_picture')]
    public function change_picture(Site $site, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PictureType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $picture =  $form->get('picture')->getData();

            if ($picture) {
                $filename = "site" . $site->getId() . "." . $picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('pictures_directory'),
                        $filename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $site->setPicture($filename);
            }

            $manager->persist($site);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'image du site <strong>'" . $site->getName() . "'</strong> a été modifiée !!!"
            );

            return $this->redirectToRoute('admin_site_show', [
                'id' => $site->getId()
            ]);
        }

        return $this->render('admin/site/picture.html.twig', [
            'title' => 'Admin - Site',
            'site' => $site,
            'form' => $form->createView()
        ]);
    }

}
