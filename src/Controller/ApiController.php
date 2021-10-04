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

        $seasons[]   = $request->get('season');
        $events[]    = $request->get('event');
        $recipeBySeason = [];
        $recipeByEvent = [];

        /* @todo : le programme n'entre jamais dans cette condition 
        et ne renvoie donc jamais toutes les données */
        if(count($seasons) == '0' && count($events) == '0'){

            $recipes = $repository->findLatest();

            return $this->json($recipes, 200, [], ['groups' => ['public_json']]);
        }
        else{

            foreach($seasons as $season){

                $recipeBySeason += $repository->findBy(['season' => $season]);
            }
            foreach($events as $event){

                $recipeByEvent += $repository->findBy(['event' => $event]);
            }

            $recipes = array_merge($recipeBySeason, $recipeByEvent);

            dump('ok');
            return $this->json($recipes, 200, [], ['groups' => ['public_json']]);
        }

    }
}
