<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Génération dynamique des recettes.
        for ($i = 0; $i < 100; $i++)
        {
            $recipe = new Recipe();
            $recipe->setName($faker->sentence(3));
            $recipe->setSlug($faker->slug());
            $recipe->setDescription($faker->text());
            $recipe->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days')));
            $recipe->setBackground(null);
            $recipe->setSeason($faker->text());


            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
