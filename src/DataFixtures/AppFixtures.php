<?php

namespace App\DataFixtures;

use Faker\Factory;

use App\Entity\User;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un générateur de données Faker en français
        $faker = Factory::create('fr_FR');

        // Création d'un utilisateur de test
        $user = new User();
        $user->setEmail('hello@codeshare.fr');
        $user->setUsername('isa');
        $user->setPassword('$2y$13$iDHNta/etBWZ4C/6o74q7OzZGcTzbLFXX1BV.HYkosu8.kW98j/BK'); // mdp = admin
        $user->setCity("Paris");
        $user->setCountry("France");
        $user->setProfilePhoto("image.jpeg")
        ;

        // Enregistrement de l'utilisateur en base de données
        $manager->persist($user);

        // Boucle pour créer 200 snippets de test
        for ($i=0; $i < 200; $i++) { 
            $article = new Article();
            $article->setTitle($faker->word(2))
            ->setContent($faker->text(200))
            ->setUser($user)
            ->setDatePublished($faker->dateTimeBetween('-7 months'))
        
            ;

            $manager->persist($article);
        }

        $manager->flush();
    }
}
