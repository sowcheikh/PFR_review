<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{

    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const APPRENANT_USER_REFERENCE = 'apprenant-user';
    public const FORMATEUR_USER_REFERENCE = 'formateur-user';
    public const CM_USER_REFERENCE = 'cm-user';

    public function load(ObjectManager $manager)
    {
        //$profileName = ["admin", "apprenant", "formateur", "CM"];
        // insertion des profiles

            $userAdmin = new Profil();
            $userAdmin->setLibelle('admin');
            $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);

            //$profil->setLibelle($profileName[$i]);
            $manager->persist($userAdmin);


            $userApprenant = new Profil();
            $userApprenant->setLibelle('apprenant');
        $this->addReference(self::APPRENANT_USER_REFERENCE, $userApprenant);


        //$profil->setLibelle($profileName[$i]);
            $manager->persist($userApprenant);

            $userFormateur = new Profil();
            $userFormateur->setLibelle('formateur');
        $this->addReference(self::FORMATEUR_USER_REFERENCE, $userFormateur);

        //$profil->setLibelle($profileName[$i]);
            $manager->persist($userFormateur);


            $userCM = new Profil();
            $userCM->setLibelle('CM');
        $this->addReference(self::CM_USER_REFERENCE, $userCM);


        //$profil->setLibelle($profileName[$i]);
            $manager->persist($userCM);
            $manager->flush();


    }
}
