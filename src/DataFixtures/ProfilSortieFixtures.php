<?php

namespace App\DataFixtures;

use App\Entity\ProfileSortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProfilSortieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        // $product = new Product();
        // $manager->persist($product);
        $profilSortie = ["developpeur front", "developpeur back", "fullstack", "CMS", "integrateur", "designer", "CM", "Data"];
        $times = 10;

        for ($i = 0; $i < $times; $i++) {
            $profilAprrenant = new ProfileSortie();
            $randomProfilSortie = random_int(0,count($profilSortie)-1);
            $profilAprrenant->setLibelle($profilSortie[$randomProfilSortie]);
            $manager->persist($profilAprrenant);
        }
        $manager->flush();
    }
}
