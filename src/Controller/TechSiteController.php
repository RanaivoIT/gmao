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

class TechSiteController extends AbstractController
{
    
    #[Route('/tech/sites', name: 'tech_site')]
    public function index(SiteRepository $siterepo): Response
    {

        $sites = $siterepo->findall();

        return $this->render('tech/site/index.html.twig', [
            'title' => 'Tech - Site',
            'sites' => $sites
        ]);
    }

    

    #[Route('/tech/sites/{id}', name: 'tech_site_show')]
    public function show(Site $site): Response
    {
        $pictures_url = $this->getParameter('pictures_url');
        return $this->render('tech/site/show.html.twig', [
            'title' => 'Tech - Site',
            'site' => $site,
            'pictures_directory' => $pictures_url
        ]);
    }

}
