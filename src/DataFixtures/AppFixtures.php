<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $recipes = [];
        $tagsArray = [];

        $tagCollection =[
            'Carottes', 'Patates', 'Poulet', 'Oignons', 'Pain', 'Saucisse', 'Pâtes feuillettée'
        ];

        foreach($tagCollection as $tag){

            $tags = new Tag();
            $tags->setName($tag);
            
            $manager->persist($tags);

            array_push($tagsArray, $tags);
        }

        // Génération dynamique des recettes et ingrédients.
        for ($i = 0; $i < 100; $i++)
        {

            $user = new User();
            $seasons = [
                'spring',
                'summer',
                'autumn',
                'winter'
            ];

            $events = [
                'christmas',
                'halloween',
                'easter',
                'bday',
                'valentineday'
            ];

            $cultures = [
                'african',
                'american',
                'asia',
                'france',
                'italian',
                'mexican'
            ];

            $type = [
                'starter',
                'dish',
                'dessert'
            ];


            $recipe = new Recipe();
            $recipe->setName($faker->sentence(3));
            $recipe->setSlug($faker->slug());
            $recipe->setDescription($faker->text());
            $recipe->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days')));
            
            //$recipe->setBackground();
            $recipe->setSeason($seasons[array_rand($seasons)]);
            $recipe->setEvent($events[array_rand($events)]);
            $recipe->setCulture($cultures[array_rand($cultures)]);
            $recipe->setType($type[array_rand($type)]);

            // Ajouter entre 2 et 10 ingrédients à une recette

            $recipe->addTag($tagsArray[array_rand($tagsArray)]);
            //$recipe->addTag($tagsArray[array_rand($tagsArray)]);
            //$recipe->addTag($tagsArray[array_rand($tagsArray)]);

            $recipe->setCreatedBy($user);

            array_push($recipes, $recipe);

            $manager->persist($recipe);
        }

        for($i = 0; $i < 10; $i++)
        {
            $user->addFavorite($recipes[array_rand($recipes)]);
        }

        $manager->persist($user);

        $manager->flush();
    }
}
