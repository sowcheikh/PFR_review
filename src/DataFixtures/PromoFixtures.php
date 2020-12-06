<?php

namespace App\DataFixtures;

use App\Entity\Promo;
use App\Entity\Referentiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PromoFixtures extends Fixture implements DependentFixtureInterface
{
    const PROMO = 'promo';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 5; $i++) {
            $promo = new Promo();
            $ref = new Referentiel();
            $promo->setTitre($faker->title)
                ->setLangue($faker->randomElement(['FR', 'EN']))
                ->setAvatar($faker->imageUrl(640, 480))
                ->setDescription($faker->text)
                ->setDateDebut($faker->dateTime)
                ->setDateFin($faker->dateTime)
                ->setFabrique('SONATEL ACDEMY')
                ->setLieu($faker->city)
                ->addGroupe($this->getReference(PromoFixtures::PROMO.$i))
                ->setReferentiel($this->getReference(ReferentielsFixtures::REF.$i));

            $manager->persist($promo);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [ReferentielsFixtures::class, GroupeFixtures::class];
    }
}
