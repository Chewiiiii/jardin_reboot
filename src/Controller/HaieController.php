<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Haie;
use App\Repository\CategorieRepository;
use App\Repository\HaieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HaieController extends AbstractController
{
    #[Route('/haie/creer', name: 'app_haie_creer')]
    public function haie_creer(ManagerRegistry $doctrine, CategorieRepository $categorie): Response
    {
        $entityManager = $doctrine->getManager();

        $haie = new Haie();
        $haie->setCode('LA');
        $haie->setNom('Laurier');
        $haie->setPrix(30);
        $categorieid = $categorie->find(1);
        $haie->setCategorie($categorieid);

        $entityManager->persist($haie);
        $entityManager->flush();
        return new Response('Type de haie créé avec le code '.$haie->getCode());

    }

//    #[Route('/haie/{code}', name: 'app_haie_voir')]
//    public function haie_voir(ManagerRegistry $doctrine, string $code): Response
//    {
//        $haie = $doctrine->getRepository(Haie::class)->find($code);
//        if (!$haie) {
//            return new Response('Ce type de haie n\'existe pas : '.$code);
//        }
//        else {
//            return new Response('Type de haie : '.$haie->getNom().' à '.$haie->getPrix().'€');
//        }
//    }

//    #[Route('/haie/{code}', name: 'app_haie_voir')]
//    public function haie_voir(string $code, HaieRepository $haieRepository): Response
//    {
//        $haie= $haieRepository->find($code);
//        if (!$haie) {
//            return new Response('Ce type de haie n\'existe pas : '.$code);
//        }
//        else {
//            return new Response('Type de haie : '.$haie->getNom().' à '.$haie->getPrix().'€');
//        }
//    }

    #[Route('/haie/modifier/{code}', name: 'app_haie_modifier')]
    public function modifier_haie(ManagerRegistry $doctrine, string $code): Response
{
    $haie = $doctrine->getRepository(Haie::class)->find($code);
    $entityManager = $doctrine->getManager();

    $haie->setPrix(8);
    $entityManager->flush();

   return $this->redirectToRoute('app_haie_voir',['code'=>$code]);
}

    /**
     * @Route("/haie/supprimer/{code}", name="supprimer_haie")
     */
    public function supprimer_haie(ManagerRegistry $doctrine, string $code): Response
    {
        $haie = $doctrine->getRepository(Haie::class)->find($code);
        $entityManager = $doctrine->getManager();

        $entityManager->remove($haie);
        $entityManager->flush();

        return $this->redirectToRoute('app_haie_voir',['code'=>$code]);
    }

    #[Route('/haie', name: 'app_haie')]
    public function index(): Response
    {
        return $this->render('haie/index.html.twig', ['controller_name' => 'HaieController',]);
    }
}
