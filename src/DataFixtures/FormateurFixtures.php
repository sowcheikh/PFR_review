<?php

namespace App\DataFixtures;

use App\Entity\Formateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FormateurFixtures extends Fixture
{
    const FORM = 'form';

    public function load(ObjectManager $manager)
    {

        $manager->flush();
    }
}
