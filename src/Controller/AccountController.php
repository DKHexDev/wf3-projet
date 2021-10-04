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
        if (!$recipe) {
            throw $this->createNotFoundException('Cette recette n\'existe pas');
        }

        // Si l'utilisateur n'est pas connecté, on le renvoie sur
        // la page de connexion.
        if (!$user) return $this->redirectToRoute('app_login');

        // Ajoute la recette qui est correspondant à l'id dans la route
        // dans les favoris.
        $user->addFavorite($recipe);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        return $this->json("La recette a bien été ajoutée aux favoris.");
    }

    /**
     * @Route("/account/favorites/{id}/remove", name="recipe_removeFav_account")
     */
    public function AccountRemoveFavorite(Recipe $recipe)
    {
        /** @var User $user */
        $user = $this->getUser();

        // Si la recette n'est pas trouvée, on redirige vers la 404.
        if (!$recipe) {
            throw $this->createNotFoundException('Cette recette n\'existe pas');
        }

        // Si l'utilisateur n'est pas connecté, on le renvoie sur
        // la page de connexion.
        if (!$user) return $this->redirectToRoute('app_login');

        // Ajoute la recette qui est correspondant à l'id dans la route
        // dans les favoris.
        $user->removeFavorite($recipe);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();

        return $this->json("La recette a bien été supprimée des favoris.");   
    }

}
