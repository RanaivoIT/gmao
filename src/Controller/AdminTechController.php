<?php

namespace App\Controller;

use App\Entity\Tech;
use App\Form\TechType;
use App\Repository\TechRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTechController extends AbstractController
{
    private $manager;
    public function __constructor(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

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
    public function add(Request $request): Response
    {
        $tech = new Tech();
        $form = $this->createForm(TechType::class, $tech);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tech);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le nouveau technicien <strong>'"+ $tech.firstname + " " + $tech.lastname +"'<strong> est ajouté !!!"
            );

            return $this->redirectToRoute('admin_tech_show', [
                'id' => $tech->getId()
            ]);
        }

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
