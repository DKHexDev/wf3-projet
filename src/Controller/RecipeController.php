<?php

namespace App\Controller;

use App\Entity\MessageRecipe;
use App\Entity\Recipe;
use App\Form\MessageRecipeType;
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
        // Récupére toutes les recettes.
        $recipes = $repository->findLatest();
        

        // Retourne la vue.
        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
            'recipes' => $recipes,
        ]);
    }

    /**
     * @Route("/recipe/create", name="recipe_create")
     */
    public function create(Request $request, SluggerInterface $slugger)
    {
        // Autorisation pour aller sur la page.
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recipe = new Recipe();

        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);

        // Vérification si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid())
        {
            // Génére le slug de la recette et l'applique.
            $slug = $slugger->slug($recipe->getName())->lower();
            $recipe->setSlug($slug);

            // Définition de la date de création.
            $recipe->setCreatedAt(new \DateTimeImmutable());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($recipe);
            $manager->flush();

            // Message de succès pour informer l'utilisateur
            $this->addFlash('green', 'La recette a bien été créé.');

            // Redirection vers la nouvelle recette.
            return $this->redirectToRoute('recipe_show', ['slug' => $recipe->getSlug()]);
        }

        // Retourne la vue.
        return $this->render('recipe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recipe/{id}/edit", name="recipe_edit")
     */
    public function edit(Recipe $recipe, Request $request)
    {
        // Autorisation pour aller sur la page.
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Si la recette n'est pas trouvée, on redirige vers la 404.
        if (!$recipe) {
            throw $this->createNotFoundException('Cette recette n\'existe pas');
        }

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        // Vérification si le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('green', 'La recette a bien été modifié');
            return $this->redirectToRoute('recipe_show', ['slug' => $recipe->getSlug()]);
        }

        // Retourne la vue.
        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe,
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
    public function show(Recipe $recipe, Request $request)
    {
        // Si la recette n'est pas trouvée, on redirige vers la 404.
        if (!$recipe) {
            throw $this->createNotFoundException('Cette recette n\'existe pas');
        }

        $messageRecipe = new MessageRecipe();
        
        $form = $this->createForm(MessageRecipeType::class, $messageRecipe);
        $form->handleRequest($request);
        
        // Vérification si le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid())
        {
            if (!$this->getUser())
            {
                $this->addFlash('red', 'Un problème est survenue lors de l\'envoi de votre message, veuillez vous connecter.');
                return $this->redirectToRoute('app_login');
            }

            $messageRecipe->setAuthor($this->getUser());
            $messageRecipe->addRecipe($recipe);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($messageRecipe);
            $manager->flush();
        
            $this->addFlash('green', 'Le message a bien été envoyé.');
        }

        // Retourne la vue.
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }

}
