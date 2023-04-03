<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Repository\ProgramRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public static int $numseasons = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($j=0; $j < ProgramFixtures::$numprograms; $j++) {
            for ($i = 0; $i < 5; $i++) {
                $season = new Season();
                $season->setNumber($faker->numberBetween(1, 10));
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $season->setProgram($this->getReference('program_' . $j));
                $manager->persist($season);
                $this->addReference('season_' . self::$numseasons, $season);
                self::$numseasons++;
            }
        }
        $manager->flush();

        //        $season = new Season();
//        $season->setNumber(1);
//        $season->setYear(2003);
//        $season->setDescription('Walter White prend conscience de sa situation et de son potentiel');
//        $season->setProgram($this->getReference('program_0'));
//        $manager->persist($season);
//        $this->addReference('season1_breaking_bad', $season);
//
//        $season = new Season();
//        $season->setNumber(2);
//        $season->setYear(2004);
//        $season->setDescription('Walter White prend conscience de sa situation et de son oo');
//        $season->setProgram($this->getReference('program_0'));
//        $manager->persist($season);
//        $this->addReference('season2_breaking_bad', $season);
    }

        public
        function getDependencies(): array
        {
            return [
                ProgramFixtures::class,
            ];
        }
    }
