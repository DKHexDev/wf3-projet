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

        $seasons = ["Hiver", "Printemps", "Été", "Automne"];

        // Génération dynamique des recettes et ingrédients.
        for ($i = 0; $i < 100; $i++)
        {
            $tags = new Tag();
            $tags->setName($faker->sentence(3));

            $recipe = new Recipe();
            $recipe->setName($faker->sentence(3));
            $recipe->setSlug($faker->slug());
            $recipe->setDescription($faker->text());
            $recipe->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days')));
            //$recipe->setBackground();
            $recipe->setSeason($seasons[array_rand($seasons)]);
            $recipe->addTag($tags);

            $manager->persist($recipe);
        }

        $user = new User();
        $user->setEmail("john.doe@doe.com");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword('$2y$13$hXnyavUYmiknXaBQjuYKTekUuW.1tbrQ7/E1.zgBCPUu8I3TsBe4G'); // Mdp : password

        $manager->persist($user);

        $manager->flush();
    }
}
