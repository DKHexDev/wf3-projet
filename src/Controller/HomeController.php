<?php

namespace App\Controller;

use Filter\Today;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(RecipeRepository $repository): Response
    {

        // On définit ici les valeurs event et season en faisant appel aux fonctions static de la classe Today()
        $event      = Today::closeToSpecial();
        $season         = Today::getSeason();

        $lastRecipes    = $repository->findBy(['description' => !'null'], ['createdAt' => 'DESC'], 3);
        $seasonRecipes  = $repository->findBy(['season' => $season], null, 3);
        $eventRecipes  = $repository->findBy(['event' => $event], null, 3);

        dump($event);
        dump($season);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
