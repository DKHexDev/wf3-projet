<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/recipes", name="api_recipe_list")
     * 
     */
    public function index(Request $request, RecipeRepository $repository): Response
    {

        $seasons  = $request->get('season', []) ;
        $events   = $request->get('event', []);
        $recipeBySeason = [];
        $recipeByEvent = [];

        if(count($seasons) == 0 && count($events) == 0){

            $recipes = $repository->findAll();

            return $this->json($recipes, 200, [], ['groups' => ['public_json']]);
        }

        else{

            if(count($seasons) > 0 ){

                foreach($seasons as $season){

                    $newRecipeBySeason = $repository->findBy(['season' => $season]);
                    $recipeBySeason = array_merge($recipeBySeason, $newRecipeBySeason);
                }
            }
            
            if(count($events) > 0 ){

                foreach($events as $event){

                    $newRecipeByEvent = $repository->findBy(['event' => $event]);
                    $recipeByEvent = array_merge($recipeByEvent, $newRecipeByEvent);
                }
            }

            $recipes = array_merge($recipeBySeason, $recipeByEvent);

            return $this->json($recipes, 200, [], ['groups' => ['public_json']]);
        }

    }
}
