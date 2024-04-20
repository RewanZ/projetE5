<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClasseFixtures extends Fixture
{
    public const ADMIN_CLASSE_REFERENCE = 'admin-classe';

    public function load(ObjectManager $manager): void
    {

        $classe = new Classe();
        $classe->setNom("PRM")
            ->setCode(2);

        $manager->persist($classe);
        $manager->flush();

        $classe = new Classe();
        $classe->setNom("Term")
            ->setCode(3);
        $manager->persist($classe);
        $manager->flush();

        $classe = new Classe();
        $classe->setNom("SCD")
            ->setCode(1);
        $manager->persist($classe);
        $manager->flush();

        $classe = new Classe();
        $classe->setNom("1TSOL")
            ->setCode(4);
        $manager->persist($classe);
        $manager->flush();

        $classe = new Classe();
        $classe->setNom("1TSSIOA")
            ->setCode(4);
        $manager->persist($classe);
        $manager->flush();

        $classe = new Classe();
        $classe->setNom("1TSCG")
            ->setCode(4);
        $manager->persist($classe);
        $manager->flush();

        $classe = new Classe();
        $classe->setNom("2TSOL")
            ->setCode(5);
        $manager->persist($classe);
        $manager->flush();


        $classe = new Classe();
        $classe->setNom("2TSSIOA")
            ->setCode(5);
        $manager->persist($classe);
        $manager->flush();


        $classe = new Classe();
        $classe->setNom("2TSCG")
            ->setCode(5);
        $manager->persist($classe);
        $manager->flush();

        $classe = new Classe();
        $classe->setNom("1TSPI")
            ->setCode(4);
        $manager->persist($classe);
        $manager->flush();

        $classe = new Classe();
        $classe->setNom("2TSPI")
            ->setCode(5);
        $manager->persist($classe);
        $manager->flush();
        $this->addReference(self::ADMIN_CLASSE_REFERENCE, $classe);
    }


}
