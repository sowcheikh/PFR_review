<?php

namespace App\DataFixtures;

use App\Entity\Competences;
use App\Entity\GroupeCompetences;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompetencesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $niveaux = ['niveau 1', 'niveau 2', 'niveau 3'];
        $groupeCompetences = ["developper le front d'une application", "developper le back d'une appication"];
        $competences = ['Créer une base de données', 'Développer les composants d’accès aux données', 'Maquetter une application','Réaliser une interface avec un CMS'];

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 2; $i++) {
            $GrpComp = new GroupeCompetences();
            $randomGrpComp = random_int(0,count($groupeCompetences)-1);
            $GrpComp->setLibelle($groupeCompetences[$randomGrpComp]);
            $GrpComp->setDescription($faker->text);
            $manager->persist($GrpComp);
        }

        for ($i = 0; $i < 5; $i++) {
            $comp = new Competences();
            $randomComp = random_int(0,count($competences)-1);
            $comp->setLibelle($competences[$randomComp]);
            $comp->setDescriptif($faker->text);
            $manager->persist($comp);
        }
        $manager->flush();
    }
}
