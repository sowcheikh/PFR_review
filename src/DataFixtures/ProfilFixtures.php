<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{

    public const ADMIN_USER_REFERENCE = 'admin';
    public const APPRENANT_USER_REFERENCE = 'apprenant';
    public const FORMATEUR_USER_REFERENCE = 'formateur';
    public const CM_USER_REFERENCE   = 'cm';

    public function load(ObjectManager $manager)
    {
        //$profileName = ["admin", "apprenant", "formateur", "CM"];
        // insertion des profiles

            $userAdmin = new Profil();
            $userAdmin->setLibelle('ADMIN');

            //$profil->setLibelle($profileName[$i]);
            $manager->persist($userAdmin);


            $userApprenant = new Profil();
            $userApprenant->setLibelle('APPRENANT');


        //$profil->setLibelle($profileName[$i]);
            $manager->persist($userApprenant);

            $userFormateur = new Profil();
            $userFormateur->setLibelle('FORMATEUR');

        //$profil->setLibelle($profileName[$i]);
            $manager->persist($userFormateur);


            $userCM = new Profil();
            $userCM->setLibelle('CM');


        //$profil->setLibelle($profileName[$i]);
            $manager->persist($userCM);
            $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
        $this->addReference(self::APPRENANT_USER_REFERENCE, $userApprenant);
        $this->addReference(self::FORMATEUR_USER_REFERENCE, $userFormateur);
        $this->addReference(self::CM_USER_REFERENCE, $userCM);





    }
}
