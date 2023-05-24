<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $program = new Program();
        $program->setTitle('Walking dead');
        $program->setSynopsis('Des zombies envahissent la terre');
        $program->setCategory($this->getReference('category_Action'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('toto');
        $program->setSynopsis('Bonjour, je suis toto !');
        $program->setCategory($this->getReference('category_Aventure'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('titi');
        $program->setSynopsis('Bonjour, je suis titi !');
        $program->setCategory($this->getReference('category_Animation'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('tata');
        $program->setSynopsis('Bonjour, je suis tata !');
        $program->setCategory($this->getReference('category_Fantastique'));
        $manager->persist($program);

        $program = new Program();
        $program->setTitle('tutu');
        $program->setSynopsis('Bonjour, je suis tutu !');
        $program->setCategory($this->getReference('category_Horreur'));
        $manager->persist($program);
        

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CategoryFixtures::class,
        ];
    }
}
