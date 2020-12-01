<?php

namespace App\DataFixtures;

use App\Entity\Competences;
use App\Entity\GroupeCompetences;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompetencesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $niveaux = ['niveau 1', 'niveau 2', 'niveau 3'];
        $groupeCompetences = ["developper le back d'une appication","developper le front d'une application" ];
        $competences = ['Créer une base de données', 'Développer les composants d’accès aux données', 'Maquetter une application','Réaliser une interface avec un CMS'];

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 2; $i++) {
            $grpComp = new GroupeCompetences();
            //$randomGrpComp = random_int(0,count($groupeCompetences)-1);
            $grpComp->setLibelle($groupeCompetences[$i]);
            $grpComp->setDescription($faker->text);


        for ($j = 0; $j < 5; $j++) {
            $comp = new Competences();

            $randomComp = random_int(0,count($competences)-1);
            $comp->setLibelle($competences[$randomComp]);
            $comp->setDescriptif($faker->text);

            $niv = new Niveau();
            $randomNiveau = random_int(0,count($niveaux)-1);
            $niv->setLibelle($niveaux[$randomNiveau]);
            $niv->setCritereEvaluation($faker->languageCode);
            $niv->setGroupeAction($faker->title);
            $comp->addNiveau($niv);
            $grpComp->addCompetence($comp);
            $manager->persist($comp);

             }
            $manager->persist($grpComp);
            $manager->flush();
        }



    }
}
