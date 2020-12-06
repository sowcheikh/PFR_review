<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GroupeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $groupe = new Groupe();
            $groupe->setNom($faker->randomElement(['G1', 'G2', 'G3', 'G4', 'G5']))
                ->setDateCreation($faker->dateTime)
                ->setStatus($faker->randomElement(['actif', 'non actif']))
                ->setType($faker->randomElement(['principal', 'secondaire']));
                $this->addReference(PromoFixtures::PROMO.$i, $groupe);
            $manager->persist($groupe);
        }




        $manager->flush();
    }
}
