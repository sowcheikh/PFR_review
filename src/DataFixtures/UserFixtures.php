<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\CM;
use App\Entity\Formateur;
use App\DataFixtures\ProfilFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        // insertion des users
        for($i=0; $i<4; $i++) {
            $userAdmin = new Admin();
            $userAdmin->setNom($faker->lastName());
            $userAdmin->setPrenom($faker->firstName());
            $userAdmin->setEmail($faker->email());
            $userAdmin->setAvatar($faker->imageUrl('640', '480'));
            $userAdmin->setProfile($this->getReference(ProfilFixtures::ADMIN_USER_REFERENCE));
            $password = $this->passwordEncoder->encodePassword($userAdmin, 'password');
            $userAdmin->setPassword($password);
            //reférencement vers les fixtures
            //$user->setProfile($this->getReference($i));
            $manager->persist($userAdmin);
        }
        for($i=0; $i<4; $i++) {
            $userApprenant = new Apprenant();
            $userApprenant->setNom($faker->lastName());
            $userApprenant->setPrenom($faker->firstName());
            $userApprenant->setEmail($faker->email());
            $userApprenant->setAvatar($faker->imageUrl('640', '480'));
            $userApprenant->setProfile($this->getReference(ProfilFixtures::APPRENANT_USER_REFERENCE));
            $password = $this->passwordEncoder->encodePassword($userApprenant, 'password');
            $userApprenant->setPassword($password);
            //reférencement vers les fixtures
            //$user->setProfile($this->getReference($i));
            $manager->persist($userApprenant);
        }
        for($i=0; $i<4; $i++) {
            $userFormateur = new Formateur();
            $userFormateur->setNom($faker->lastName());
            $userFormateur->setPrenom($faker->firstName());
            $userFormateur->setEmail($faker->email());
            $userFormateur->setAvatar($faker->imageUrl('640', '480'));
            $userFormateur->setProfile($this->getReference(ProfilFixtures::FORMATEUR_USER_REFERENCE));
            $password = $this->passwordEncoder->encodePassword($userFormateur, 'password');
            $userFormateur->setPassword($password);
            //reférencement vers les fixtures
            //$user->setProfile($this->getReference($i));
            $manager->persist($userFormateur);
        }
        for($i=0; $i<4; $i++) {
            $userCM = new CM();
            $userCM->setNom($faker->lastName());
            $userCM->setPrenom($faker->firstName());
            $userCM->setEmail($faker->email());
            $userCM->setAvatar($faker->imageUrl('640', '480'));
            $userCM->setProfile($this->getReference(ProfilFixtures::CM_USER_REFERENCE));
            $password = $this->passwordEncoder->encodePassword($userCM, 'password');
            $userCM->setPassword($password);
            //reférencement vers les fixtures
            //$user->setProfile($this->getReference($i));
            $manager->persist($userCM);
        }
        $manager->flush();

    }


}
