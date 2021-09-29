<?php

namespace App\DataFixtures;

use App\Entity\Tag;
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
            $tags = new Tag();
            $tags->setName($faker->sentence(3));

            $season = [
                'spring',
                'summer',
                'autumn',
                'winter'
            ];
            $seasonRand= array_rand($season);

            $event = [
                'christmas',
                'nationalDay',
                'halloween',
                'easter'
            ];
            $eventRand= array_rand($event);

            $recipe = new Recipe();
            $recipe->setName($faker->sentence(3));
            $recipe->setSlug($faker->slug());
            $recipe->setDescription($faker->text());
            $recipe->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 days')));
            
            //$recipe->setBackground();
            $recipe->setSeason($season[$seasonRand]);
            $recipe->setEvent($event[$eventRand]);
            $recipe->addTag($tags);

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
