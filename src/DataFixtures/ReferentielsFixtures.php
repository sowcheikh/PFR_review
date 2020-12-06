<?php

namespace App\DataFixtures;

use App\Entity\Brief;
use App\Entity\GroupeCompetences;
use App\Entity\Referentiel;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReferentielsFixtures extends Fixture

{
    private $groupeCompetencesRepository;
    const REF = 'ref';

public function __construct(GroupeCompetencesRepository $groupeCompetencesRepository)
{
    $this->groupeCompetencesRepository = $groupeCompetencesRepository;

}

    public function load(ObjectManager $manager)
    {


        $referentiels = ['Développement Web et mobile', 'reference digitale', 'data science'];
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $ref = new Referentiel();
            $brief = new Brief();
            $grpcom = $this->groupeCompetencesRepository->find(1);
            $randomRef= random_int(0, count($referentiels) - 1);
            $ref->setLibelle($referentiels[$randomRef]);
            $ref->setPresentation($faker->text);
            $ref->setCritereEvaluation("Un portfolio comprenant la réalisation d'au moins 9 projets tout au long de la formation");
            $ref->setCritereAdmission('Une soutenance devant un jury de professionnels');
            $ref->setProgramme('uploader le programme');
            $ref->addGroupeCompetence($grpcom);
            $this->addReference(ReferentielsFixtures::REF.$i, $ref);
            $manager->persist($ref);
        }

        $manager->flush();
    }
}
