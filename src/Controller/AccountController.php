<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, on le renvoie sur
        // la page de connexion.
        if (!$user) return $this->redirectToRoute('app_login');

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/account/favorites/{id}/add", name="recipe_addFav_account")
     */
    public function AccountAddFavorite(Recipe $recipe)
    {
        /** @var User $user */
        $user = $this->getUser();

        // Si la recette n'est pas trouvée, on redirige vers la 404.
        if (!$recipe) return $this->json(["color" => "red", "message" => "Cette recette n'existe pas.", "changeClass" => false]);

        // Si l'utilisateur n'est pas connecté, on le renvoie sur
        // la page de connexion.
        if (!$user) return $this->json(["color" => "red", "message" => "Impossible, vous devez avoir un compte pour ajouter une recette à vos favoris.", "changeClass" => false]);

        // Ajoute la recette qui est correspondant à l'id dans la route
        // dans les favoris.
        $user->addFavorite($recipe);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        return $this->json(["color" => "green", "message" => "La recette a bien été ajoutée aux favoris.", "changeClass" => true]);
    }

    /**
     * @Route("/account/favorites/{id}/remove", name="recipe_removeFav_account")
     */
    public function AccountRemoveFavorite(Recipe $recipe)
    {
        /** @var User $user */
        $user = $this->getUser();

        // Si la recette n'est pas trouvée, on redirige vers la 404.
        if (!$recipe) return $this->json(["color" => "red", "message" => "Cette recette n'existe pas.", "changeClass" => false]);

        // Si l'utilisateur n'est pas connecté, on le renvoie sur
        // la page de connexion.
        if (!$user) return $this->json(["color" => "red", "message" => "Impossible, vous devez avoir un compte pour ajouter une recette à vos favoris.", "changeClass" => false]);

        // Ajoute la recette qui est correspondant à l'id dans la route
        // dans les favoris.
        $user->removeFavorite($recipe);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        return $this->json(["color" => "red", "message" => "La recette a bien été supprimée des favoris.", "changeClass" => true]);   
    }

}
