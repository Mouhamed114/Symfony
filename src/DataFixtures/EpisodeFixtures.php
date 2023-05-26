<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
   /* const EPISODES = [
        ['title' => 'Black Knight', 'synopsis' => 'En 2071, le monde a été ravagé par la pollution de l\'air. La survie de l\'humanité dépend de livreurs atypiques surnommés les "chevaliers noirs"', 'number' => '1', 'season' => 'season_1'],
        ['title' => 'One piece', 'synopsis' => 'Monkey D.Luffy cherche à devenir le nouveau roi des Pirates et retrouver le fameux OnePiece ! ', 'number' => '2', 'season' => 'season_2'],
        ['title' => 'DemonSlayer', 'synopsis' => 'Tanjiro rejoint les pourfendeurs et part à la recherche des lunes supérieurs pour venger sa famille', 'number' => '3', 'season' => 'season_3'],
        ['title' => 'Game of Thrones', 'synopsis' => 'Après un été de dix années, un hiver rigoureux s\'abat sur le Royaume avec la promesse d\'un avenir des plus sombres. Pendant ce temps, complots et rivalités se jouent sur le continent pour s\'emparer du Trône de Fer, le symbole du pouvoir absolu.', 'number' => '4', 'season' => 'season_4'],
        ['title' => 'The Walking Dead', 'synopsis' => 'L histoire suit les aventures du shériff Rick Grimes, qui se réveille après à un coma au milieu d une envahison de zombies', 'number' => '5', 'season' => 'season_5'],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODES as $episodeLine) {
            $episode = new Episode();
            $episode->setTitle($episodeLine['title']);
            $episode->setSynopsis($episodeLine['synopsis']);
            $episode->setNumber($episodeLine['number']);
            $episode->setSeason($this->getReference($episodeLine['season']));
            $manager->persist($episode);
            $this->addReference('episode' . $episodeLine['title'], $episode);
        }
        $manager->flush();
    } */

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach (PROGRAMFixtures::PROGRAMS as $program) {
           for($j = 1; $j<=5; $j++){
            for ($i = 1; $i <= 12; $i++) {
                $episode = new Episode();
                $episode->setNumber($i);
                $episode->setTitle($faker->year());
                $episode->setSynopsis($faker->paragraph(3, true));
                $episode->setSeason($this->getReference('season'. $j.'_' . $program['title']));
                $manager->persist($episode);
            }
        }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          SeasonFixtures::class,
        ];
    }
}
