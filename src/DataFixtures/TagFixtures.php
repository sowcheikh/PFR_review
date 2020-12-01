<?php

namespace App\DataFixtures;

use App\Entity\GroupeTag;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $groupeTgag = ['Développement Mobile', 'Systèmes et réseaux', 'Objets connectés'];
        $times = 10;

        for ($i = 0; $i < $times; $i++) {
            $tag = new Tag();
            $grpTag = new GroupeTag();


            $tag->setLibelle($faker->languageCode);
            $tag->setDescription($faker->text);
            $randomGrpTag = random_int(0,count($groupeTgag)-1);
            $grpTag->setLibelle($groupeTgag[$randomGrpTag]);
            $grpTag->addTag($tag);
            $manager->persist($grpTag);
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
