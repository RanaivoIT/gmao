<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Site;
use App\Entity\Tech;
use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Piece;
use App\Entity\Organe;
use App\Entity\Service;
use App\Entity\Equipement;
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
        $faker = Factory::create('en_US');
        
        $superadmin = new Admin();

        $superadmin->setFirstname($faker->firstname())
                ->setLastname($faker->lastname())
                ->setJob($faker->jobTitle())
                ->setAddress($faker->address())
                ->setcontact($faker->phoneNumber())
                ->setEmail($faker->email())
                ->setHash($this->encoder->hashPassword($superadmin, "password"))
                ->setAvatar("avatar.png")
                ->setRoles(['ROLE_SUPER_ADMIN', 'ROLE_ADMIN']);
        $manager->persist($superadmin);
        
        for ($i=0; $i < mt_rand(2, 5) ; $i++) { 
            $admin = new Admin();

            $admin->setFirstname($faker->firstname())
                    ->setLastname($faker->lastname())
                    ->setJob($faker->jobTitle())
                    ->setAddress($faker->address())
                    ->setcontact($faker->phoneNumber())
                    ->setEmail($faker->email())
                    ->setHash($this->encoder->hashPassword($admin, "password"))
                    ->setAvatar("avatar.png")
                    ->setRoles(['ROLE_ADMIN']);
            $manager->persist($admin);
        }

        for ($i=0; $i < mt_rand(2, 5) ; $i++) { 
            $tech = new Tech();

            $tech->setFirstname($faker->firstname())
                    ->setLastname($faker->lastname())
                    ->setSpeciality($faker->jobTitle())
                    ->setAddress($faker->address())
                    ->setcontact($faker->phoneNumber())
                    ->setEmail($faker->email())
                    ->setHash($this->encoder->hashPassword($admin, "password"))
                    ->setAvatar("avatar.png")
                    ->setRoles(['ROLE_TECH']);
            $manager->persist($tech);
        }
       
        for ($i=0; $i < mt_rand(2, 5) ; $i++) { 
           $site = new Site();
           $site
                ->setName($faker->company())
                ->setAddress($faker->address())
                ->setContact($faker->phoneNumber())
                ->setEmail($faker->companyEmail())
                ->setPicture("site.jpg");

                for ($j=0; $j < mt_rand(2, 5); $j++) { 
                    $user = new User();

                    $user->setFirstname($faker->firstname())
                            ->setLastname($faker->lastname())
                            ->setJob($faker->jobTitle())
                            ->setAddress($faker->address())
                            ->setcontact($faker->phoneNumber())
                            ->setEmail($faker->email())
                            ->setHash($this->encoder->hashPassword($admin, "password"))
                            ->setAvatar("avatar.png")
                            ->setRoles(['ROLE_USER'])
                            ->setSite($site);
                    $manager->persist($user);
                }

                for ($j=0; $j < mt_rand(2, 5); $j++) { 
                    $service = new Service();
                    $service->setName($faker->jobTitle())
                        ->setSite($site);
                    $manager->persist($service);
                }
            $manager->persist($site);
        }

        for ($i=0; $i < mt_rand(5, 10) ; $i++) { 
            $equipement = new Equipement();
            $equipement
                ->setName($faker->company())
                ->setMaker($faker->company())
                ->setOrigin($faker->state())
                ->setDescription($faker->sentence())
                ->setPicture("equipement.png");

                for ($j=0; $j < mt_rand(3, 10); $j++) { 
                    $organe = new Organe();
                    $organe->setName($faker->company())
                        ->setEquipement($equipement);

                    for ($j=0; $j < mt_rand(3, 10); $j++) { 
                        $piece = new Piece();
                        $piece->setName($faker->company())
                            ->setRef($faker->company())
                            ->setAmount(mt_rand(1, 10))
                            ->setOrgane($organe);
                        $manager->persist($piece);
                    }
                            
                    $manager->persist($organe);
                }
    
            $manager->persist($equipement);
        }

        $manager->flush();
    }
}
