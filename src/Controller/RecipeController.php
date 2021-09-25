<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use App\Filter\filter\Filter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    /**
     * @Route("/recipe", name="recipe_list")
     */
    public function index(RecipeRepository $repository, Filter $filtres): Response
    {
        // Instanciation de la classe filtre ( à modifier ) qui renvoie un tableau de filtres
        // l'objet filter sera nourri grâce à des requêtes ajax.

        $filter = $filtres; 

        if($filter){

            // Récupère un tableau pour chaque filtre activé
            $recipeSeason   = $repository->findBy(

                ['season' => $this->filtre['season']],
                ['createdAt' => 'DESC']);

            $recipeEvent    = $repository->findBy(
                
                ['event' => $this->filtres['recipes']],
                ['createdAt' => 'DESC']);

            // Fusionne les tableaux pour donner toutes les recette à afficher
            $recipes = array_merge($recipeSeason, $recipeEvent);
        }
        else{

            // Récupération de toutes les recettes en base de données.
            
            $recipes = $repository->findAll();
        }

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }
}
