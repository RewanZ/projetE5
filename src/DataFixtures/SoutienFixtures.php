<?php

namespace App\DataFixtures;

use App\Entity\Soutien;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use phpDocumentor\Reflection\Types\This;

class SoutienFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_SOUTIEN_REFERENCE = 'admin-soutien';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i<400;$i++){
            $soutien= new Soutien();

            //$random = mt_rand(0, 10); // Génère un nombre aléatoire entre 0 et 10 inclusivement
            //$reference = $this->getReference(sprintf(MatiereFixtures::ADMIN_MATIERE_REFERENCE, $random));
            $soutien->setDateDuSoutien($faker->dateTimeBetween('-1 year', '+45 days', 'Europe/Paris'))
                ->setDateUpdated($faker->dateTimeBetween('-1 month', '-2 days', 'Europe/Paris'))
                ->setDescription($faker->words(1, true))
                ->setMatiere($this->getReference(MatiereFixtures::ADMIN_MATIERE_REFERENCE))
                ->setSousMatiere($this->getReference(MatiereFixtures::ADMIN_MATIERE_REFERENCE))
            ;
//            $random = mt_rand(0, 10); // Génère un nombre aléatoire entre 0 et 10 inclusivement
//            $reference = $this->getReference(sprintf(MatiereFixtures::ADMIN_MATIERE_REFERENCE, $random));
//            $soutien->setDateDuSoutien($faker->dateTimeBetween('-1 year', '+45 days', 'Europe/Paris'))
//                ->setDateUpdated($faker->dateTimeBetween('-1 month', '-2 days', 'Europe/Paris'))
//                ->setDescription($faker->words(1, true))
//                ->setMatiere($reference)
//                ->setSousMatiere($this->getReference(MatiereFixtures::ADMIN_MATIERE_REFERENCE)->getSousMatiere()[rand(0,2)])
//            ;


            //dd($reference);
            $manager->persist($soutien);
        }
        $manager->flush();
        $this->addReference(self::ADMIN_SOUTIEN_REFERENCE, $soutien);

    }
    public function getDependencies()
    {
        return [
            MatiereFixtures::class,
        ];
    }



}
