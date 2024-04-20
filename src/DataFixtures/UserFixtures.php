<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i<300;$i++){
            //$randomClass = $faker->randomElement($classes);

            $user= new User();
            $user->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setClasse($this->getReference(ClasseFixtures::ADMIN_CLASSE_REFERENCE))
                ->setEmail($faker->email)
                ->setPassword($faker->password(10,40))
                ->setNiveau($faker->randomElement(["PRM", 'Term', 'SCD', "2TSOL","1TSOL", "1TSSIOA", "2TSSIOA"]))
                ->setSexe($faker->numberBetween(0,2))
                ->setTelephone($faker->phoneNumber)
                ->setUsername($faker->userName)
                ->setRoles([$faker->randomElement(["ROLE_ADMIN","ROLE_USER"])])
            ;

            //dd($user->getRoles());
            $manager->persist($user);
        }

        $manager->flush();
        $this->addReference(self::ADMIN_USER_REFERENCE, $user);

    }
    public function getDependencies()
    {
        return [
            ClasseFixtures::class,
        ];
    }
}
