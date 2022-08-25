<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tech;
use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        $superadmin = new Admin();

        $superadmin->setFirstname($faker->firstname())
                ->setLastname($faker->lastname())
                ->setAddress($faker->address())
                ->setcontact($faker->phoneNumber())
                ->setEmail($faker->email())
                ->setHash($this->encoder->hashPassword($superadmin, "password"))
                ->setAvatar("/img/avatar.png")
                ->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN']);
        $manager->persist($superadmin);
        
        for ($i=0; $i < 10 ; $i++) { 
            $admin = new Admin();

            $admin->setFirstname($faker->firstname())
                    ->setLastname($faker->lastname())
                    ->setAddress($faker->address())
                    ->setcontact($faker->phoneNumber())
                    ->setEmail($faker->email())
                    ->setHash($this->encoder->hashPassword($admin, "password"))
                    ->setAvatar("/img/avatar.png")
                    ->setRoles(['ROLE_ADMIN']);
            $manager->persist($admin);
        }

        for ($i=0; $i < 10 ; $i++) { 
            $tech = new Tech();

            $tech->setFirstname($faker->firstname())
                    ->setLastname($faker->lastname())
                    ->setSpeciality($faker->jobTitle())
                    ->setAddress($faker->address())
                    ->setcontact($faker->phoneNumber())
                    ->setEmail($faker->email())
                    ->setHash($this->encoder->hashPassword($admin, "password"))
                    ->setAvatar("/img/avatar.png")
                    ->setRoles(['ROLE_TECH']);
            $manager->persist($tech);
        }
       


        $manager->flush();
    }
}
