<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Recipe;
use App\Form\AccountSettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

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

    /**
     * @Route("/account/settings", name="account_settings")
     */
    public function AccountSettings(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        UserAuthenticatorInterface $guard,
        LoginFormAuthenticator $authenticator
    )
    {
        /** @var User $user */
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, on le renvoie sur
        // la page de connexion.
        if (!$user) return $this->redirectToRoute('app_login');

        $form = $this->createForm(AccountSettingsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('pseudo')->getData() && $form->get('password')->getData() == null)
            {
                $user->setPassword($user->getPassword());
            }
            else if ($form->get('pseudo')->getData() && $form->get('password')->getData() != null)
            {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );    
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('green', 'Vos informations ont été mis à jour.');
        }

        return $this->render('account/settings.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/account/favorites", name="account_favorites")
     */
    public function AccountFavorites(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, on le renvoie sur
        // la page de connexion.
        if (!$user) return $this->redirectToRoute('app_login');

        $recipesFavorite = $user->getFavorites();

        return $this->render('account/favorites.html.twig', [
            'favorites' => $recipesFavorite,
        ]);
    }

}
