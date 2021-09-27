<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    /**
     * @Route("/recipe", name="recipe_list")
     */
    public function index(RecipeRepository $repository): Response
    {
        // Instanciation de la classe filtre ( à modifier ) qui renvoie un tableau de filtres
        // l'objet filter sera nourri grâce à des requêtes ajax.


        $recipes = $repository->findAll();


        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }
}
