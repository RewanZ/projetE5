<?php

namespace App\DataFixtures;

use App\Entity\Salle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SalleFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_SALLE_REFERENCE = 'admin-salle';

    public function load(ObjectManager $manager): void
    {
        $salle=new Salle();
        $salle->setCodeSalle('C502')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);

        $salle=new Salle();
        $salle->setCodeSalle('C501')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);

        $salle=new Salle();
        $salle->setCodeSalle('C503')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);

        $salle=new Salle();
        $salle->setCodeSalle('C504')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);

        $salle=new Salle();
        $salle->setCodeSalle('C505')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);
        $salle=new Salle();
        $salle->setCodeSalle('C505')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);

        $salle=new Salle();
        $salle->setCodeSalle('C301')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);

        $salle=new Salle();
        $salle->setCodeSalle('C302')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);

        $salle=new Salle();
        $salle->setCodeSalle('C303')->addSoutien($this->getReference(SoutienFixtures::ADMIN_SOUTIEN_REFERENCE));
        $manager->persist($salle);


        $manager->flush();
        $this->addReference(self::ADMIN_SALLE_REFERENCE, $salle);
    }

    public function getDependencies()
    {
        return [
            SoutienFixtures::class,
        ];    }
}
