<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Matiere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MatiereFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_MATIERE_REFERENCE = 'admin-matiere';

    public function load(ObjectManager $manager): void
    {
        //$dec=$this->getReference(ClasseFixtures::ADMIN_CLASSE_REFERENCE);
        $classes = $manager->getRepository(Classe::class)->findAll();
        $faker = Factory::create('fr_FR');

        $matiere = new Matiere();
        $matiere->setDesignation('Maths')
            ->setSousMatiere(['complexes'])
            ->addSousMatiere('fonctions affines')
            ->addSousMatiere('Exponentielles')
            ->addSousMatiere('Nombre Binaires')
            ->addClass($faker->randomElement([$this->getReference(ClasseFixtures::ADMIN_CLASSE_REFERENCE)]))
        ;
        //dd($matiere);
        $manager->persist($matiere);

        $manager->flush();

        $matiere = new Matiere();
        $matiere->setDesignation('Français')
            ->setSousMatiere(['conjugaison'])
            ->addSousMatiere('Texte')
            ->addSousMatiere('Littérature')
            ->addSousMatiere('Vocabulaire')
            ->addClass($faker->randomElement([$this->getReference(ClasseFixtures::ADMIN_CLASSE_REFERENCE)]))
        ;
        $manager->persist($matiere);
        $this->setReference( self::ADMIN_MATIERE_REFERENCE, $matiere);
        $manager->flush();

        $matiere = new Matiere();
        $matiere->setDesignation('Anglais')
            ->setSousMatiere(['Verbes Irréguliers'])
            ->addSousMatiere('Verbes Réguliers')
            ->addSousMatiere('Modaux')
            ->addSousMatiere('Traduction')
            ->addClass($faker->randomElement([$this->getReference(ClasseFixtures::ADMIN_CLASSE_REFERENCE)]))
        ;
        $manager->persist($matiere);
        $this->setReference( self::ADMIN_MATIERE_REFERENCE, $matiere);
        $manager->flush();

    }
    public function getDependencies()
    {
        return [
            ClasseFixtures::class,
        ];
    }

}
