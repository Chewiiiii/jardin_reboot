<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'app_devis')]
    public function index(): Response
    {
        $request = Request::createFromGlobals();
        $haie = $request->get('haie');
        $hauteur = $request->get('hauteur');
        $longueur = $request->get('longueur');
        $session = new Session;
        $choix = $session->get('choix');

        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'haie'=> $haie,
            'hauteur' => $hauteur,
            'longueur' => $longueur,
            'choix' => $choix,
        ]);

    }


    public function newDevis(Request $request, EntityManager $entityManager)
    {
        $devis = new Devis();
        $form = $this-> createForm(DevisType::class);
        $form-> handleRequest($request) ; 

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($devis);
            $entityManager->flush();
            $session = new Session();
            $session->set("idDevis", $devis->getId());

            return $this->redirectToRoute('app_devis', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('devis/index.html.twig', [
            'devis' => $devis,
            'form' => $form
        ]);

    }
}
