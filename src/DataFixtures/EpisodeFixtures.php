<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($j=0; $j < SeasonFixtures::$numseasons; $j++){
            for($i=0; $i<10; $i++){
                $episode = new Episode();
                $episode->setTitle($faker->word());
                $episode->setNumber($faker->numberBetween(0, 10));
                $episode->setSynopsis($faker->paragraph());
                $episode->setSeason($this->getReference('season_' . $j));
                $manager->persist($episode);
            }
        }
        $manager->flush();

//        $episode = new Episode();
//        $episode->setTitle('Le commencement');
//        $episode->setNumber(1);
//        $episode->setSynopsis("l'aventure commence pour Walter");
//        $episode->setSeason($this->getReference('season_0'));
//        $manager->persist($episode);
//        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
