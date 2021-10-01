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

        foreach($seasons as $season){

            $recipeBySeason += $repository->findBy(['season' => $season]);
        }
        dump($recipeBySeason);

        return $this->json("ok");
    }
}
