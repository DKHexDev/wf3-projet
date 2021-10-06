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

        // Génération dynamique des recettes et ingrédients.
        for ($i = 0; $i < 100; $i++)
        {
            $tags = new Tag();
            $tags->setName($faker->sentence(3));

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


            $recipe = new Recipe();
            $recipe->setName($faker->sentence(3));
            $recipe->setSlug($faker->slug());
            $recipe->setDescription($faker->text());
            $recipe->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days')));
            
            //$recipe->setBackground();
            $recipe->setSeason($seasons[array_rand($seasons)]);
            $recipe->setEvent($events[array_rand($events)]);
            $recipe->addTag($tags);
            $recipe->setCreatedBy('Toto');

            array_push($recipes, $recipe);

            $manager->persist($recipe);
        }

        $user = new User();
        $user->setEmail("john.doe@doe.com");
        $user->setPseudo('Johnny');
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword('$2y$13$hXnyavUYmiknXaBQjuYKTekUuW.1tbrQ7/E1.zgBCPUu8I3TsBe4G'); // Mdp : password

        for($i = 0; $i < 10; $i++)
        {
            $user->addFavorite($recipes[array_rand($recipes)]);
        }

        $manager->persist($user);

        $manager->flush();
    }
}
