<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        ['Number' => '1','Year' => '2019', 'Description' => 'La découverte de baby Yoda!', 'Program' => 'Black Knight'],
        ['Number' => '2','Year' => '2021', 'Description' => 'Baby Yoda s\'appel Grogu et est livré à Luke!', 'Program' => 'One piece'],
        ['Number' => '3','Year' => '2023', 'Description' => 'Le retour des Mandaloriens!', 'Program' => 'DemonSlayer'],
        ['Number' => '4','Year' => '2024', 'Description' => 'Aucune idée, on verra bien!', 'Program' => 'Game of Thrones'],
        ['Number' => '5','Year' => '2026', 'Description' => 'Une version moderne du célèbre détective et de son partenaire médecin résolvant le crime dans la ville de Londres au XXIème siècle!', 'Program' => 'The Walking Dead'],

    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASONS as $seasonLine) {
            $season = new Season();
            $season->setNumber($seasonLine['Number']);
            $season->setYear($seasonLine['Year']);
            $season->setDescription($seasonLine['Description']);
            $season->setProgram($this->getReference($seasonLine['Program']));
            $manager->persist($season);
            $this->addReference('season_' . $seasonLine['Number'], $season);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ProgramFixtures::class,
        ];
    }
}
