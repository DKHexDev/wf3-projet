<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RecipeController extends AbstractController
{
    /**
     * @Route("/recipe", name="recipe_list")
     */
    public function index(RecipeRepository $repository): Response
    {

            $recipes = $repository->findAll();

        return $this->render('recipe/index.html.twig', [
            'recipe' => $recipes,
            'controller_name' => 'RecipeController',
        ]);
    }

    /**
     * @Route("/recipe/{id}/delete", name="recipe_delete")
     */
    public function delete(Recipe $recipe)
    {
        // Autorisation pour aller sur la page.
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Si la recette n'est pas trouvée, on redirige vers la 404.
        if (!$recipe) {
            throw $this->createNotFoundException('Cette recette n\'existe pas');
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($recipe);
        $manager->flush();
        
        // Message de succès pour informer l'utilisateur
        $this->addFlash('red', "La recette a bien été supprimée.");

        return $this->redirectToRoute('recipe_list');
    }

    /**
     * @Route("/recipe/{slug}", name="recipe_show")
     */
    public function show(Recipe $recipe)
    {
        // Si la recette n'est pas trouvée, on redirige vers la 404.
        if (!$recipe) {
            throw $this->createNotFoundException('Cette recette n\'existe pas');
        }

        dump($recipe->getTags());

        // Retourne la vue.
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

}
