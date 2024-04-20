<?php

namespace App\DataFixtures;

use App\Entity\Demande;
use App\Entity\Matiere;
use App\Entity\Soutien;
use App\Repository\MatiereRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Bundle\SecurityBundle\Security;

class DemandeFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_DEMANDE_REFERENCE = 'admin-demande';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        //$matiere=$this->matiereRepository->findOneBy(['id']);
        //dd($matiere);

        for ($i = 1; $i <= 200; $i++) {

            $random=random_int(1,7);
            $dateUpdated=$faker->dateTimeBetween('-1 year', '+2 months', 'Europe/Paris');
            $dateFinDemande=$faker->dateTimeBetween('-1 year', '+2 months', 'Europe/Paris');
            $sousMatiere=$faker->word;
            $idUser=$this->getReference(UserFixtures::ADMIN_USER_REFERENCE);
            $demande = new Demande();
            $demande->setIdMatiere($this->getReference(MatiereFixtures::ADMIN_MATIERE_REFERENCE))
                //dd($demande);
                ->setDateUpdated($dateUpdated)
                //$this->sousMatiereRepository->find($randomSousMatiereId);
                ->setSousMatiere($sousMatiere)
                ->setStatus($random)
                ->setDateFinDemande($dateFinDemande)
                ->setIdUser($idUser);
            if ($random==2 or $random==3){
                $soutien=new Soutien();
                $demande->setAssistant($idUser);
                $soutien->setMatiere($this->getReference(MatiereFixtures::ADMIN_MATIERE_REFERENCE))
                        ->setSousMatiere($sousMatiere)
                        ->setDescription('soutien-'.$i)
                        ->setDateUpdated($dateUpdated)
                        ->setDateDuSoutien($faker->dateTimeBetween('-1 year', '+2 months', 'Europe/Paris'))
                        ->setSalle($this->getReference(SalleFixtures::ADMIN_SALLE_REFERENCE));
            }
            $manager->persist($demande);
    }


        $manager->flush();
        $this->addReference(self::ADMIN_DEMANDE_REFERENCE, $demande);
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            MatiereFixtures::class,
            SalleFixtures::class
        ];
    }
}
