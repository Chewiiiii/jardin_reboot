<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;

class CreerHaieController extends AbstractController
{
    #[Route('/creer/haie', name: 'app_creer_haie')]
    public function index(): Response
    {
        return $this->render('creer_haie/index.html.twig', [
            'controller_name' => 'CreerHaieController',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $option): void
    {
        $builder
        ->add('code', TextType::class, array('label'=>'Code haie'))
        ->add('nom', TextType::class, array('label'=>'Nom haie'))
        ->add('prix', NumberType::class, array('label'=>'Tarif Haie', 'invalid_message' =>'Saisir un nombre'))
        ->add('categorie', EntityType::class, [
            'label'=>'Categorie haie', 
            'class'=> Categorie::class, 
            'choice_label'=> 'libelle'])
        ->add('save', SubmitType::class, array('label'=>'VALIDER'))
        ;
    }

public function configureOption(OptionsResolver $resolver):void
{
    $resolver -> setDefaults(['data_class'=> Haie::class,]);
}

}
