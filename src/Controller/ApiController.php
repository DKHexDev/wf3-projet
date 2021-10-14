<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Recipe;
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
    public function index(Request $request, RecipeRepository $repository): Response{

        $seasons  = $request->get('season', []);
        $events   = $request->get('event', []);
        $cultures = $request->get('culture', []);
        $types    = $request->get('type',[]);

        $page     = $request->get('page', 0);

        $recipeBySeason = [];
        $recipeByEvent = [];
        $recipeByCulture = [];
        $recipeByType = [];

        /** @var User $user */
        $user = $this->getUser();

        $userLogin = false;

        // Si l'utilisateur est connecté, on renvoie true (pour le système des favoris)
        if ($user)
        {
            $userLogin = true;
        }

        if((count($seasons) + count($events) + count($cultures) + count($types)) == 0){

            $recipes = $repository->findAll();

            return $this->json(["userLogin" => $userLogin, $recipes], 200, [], ['groups' => ['public_json']]);
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

            if(count($cultures) > 0 ){

                foreach($cultures as $culture){

                    $newRecipeByCulture = $repository->findBy(['culture' => $culture]);
                    $recipeByCulture = array_merge($recipeByCulture, $newRecipeByCulture);
                }
            }

            if(count($types) > 0 ){

                foreach($types as $type){

                    $newRecipeByType = $repository->findBy(['type' => $type]);
                    $recipeByType = array_merge($recipeByType, $newRecipeByType);
                }
            }

            $recipes = array_merge($recipeBySeason, $recipeByEvent, $recipeByCulture, $recipeByType);
            $recipesPages = array_chunk($recipes, 25, false);

            return $this->json(['userLogin' => $userLogin, $recipesPages[$page]], 200, [], ['groups' => ['public_json']]);
        }

    }

    /**
     * @Route("/api/recipes/list", name="api_recipes_courseslist")
     * 
     */
    public function generate(Request $request, RecipeRepository $repository) : Response{

        $idList = $request->get('id', []);

        $ingredientList = [];

        foreach($idList as $id){

            $recipe = $repository->findBy(['id' => $id]);
            $ingredientCollection =  $recipe[0]->getTags();
            $ingredients = $ingredientCollection->getValues();

            foreach($ingredients as $ingredient){

                if(!in_array($ingredient, $ingredientList)){

                    array_push($ingredientList, $ingredient);
                }
            }
        }

        return $this->json($ingredientList, 200, [], ['groups' => 'public_json']);
    }

    /**
     * @Route("/api/recipes/search", name="api_recipes_search")
     * 
     */
    public function searchByName(Request $request, RecipeRepository $recipeRepository): Response{

        $searchTerms = $request->get('searchTerms');

        $recipes = $recipeRepository->findByNameLike($searchTerms);

        return $this->json($recipes, 200, [], ['groups' => 'public_json']);
    }
}