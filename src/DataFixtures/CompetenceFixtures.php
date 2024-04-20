<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompetenceFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_COMPETENCE_REFERENCE = 'admin-competence';

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 200; $i++) {
        $matiereReference = $this->getReference(MatiereFixtures::ADMIN_MATIERE_REFERENCE);
        //dd($matiereReference->getSousMatiere());

        $competence = new Competence();
        $competence->setMatiere($matiereReference)
            ->setSousMatiere($matiereReference->getSousMatiere()[rand(0,1)])
            ->setLesAssistants([$this->getReference(UserFixtures::ADMIN_USER_REFERENCE)->getId()])
        ->addAssistants([$this->getReference(UserFixtures::ADMIN_USER_REFERENCE)->getId()-$i]);
           // dd($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $manager->persist($competence);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            MatiereFixtures::class,
            UserFixtures::class,
        ];
    }
}
