<?php

namespace App\Controller;

use App\Entity\Tech;
use App\Form\TechType;
use App\Repository\TechRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTechController extends AbstractController
{
    #[Route('/admin/tech', name: 'admin_tech')]
    public function index(TechRepository $techrepo): Response
    {

        $techs = $techrepo->findall();

        return $this->render('admin/tech/index.html.twig', [
            'title' => 'Admin - Tech',
            'techs' => $techs
        ]);
    }

    #[Route('/admin/tech/add', name: 'admin_tech_add')]
    public function add(): Response
    {
        $tech = new Tech();
        $form = $this->createForm(TechType::class, $tech);

        return $this->render('admin/tech/form.html.twig', [
            'title' => 'Admin - Tech',
            'tech' => $tech,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/tech/{id}', name: 'admin_tech_show')]
    public function show(Tech $tech): Response
    {
        return $this->render('admin/tech/show.html.twig', [
            'title' => 'Admin - Tech',
            'tech' => $tech
        ]);
    }

}
