<?php

namespace App\DataFixtures;

use App\Entity\Idea;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IdeaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 40; $i++) {
            $idea = new Idea();
            $idea->setTitle($faker->realText(40, 2));
            $idea->setContent($faker->realTextBetween(160, 500, 2));
            $idea->setAuthor($this->getReference('author_' . $faker->numberBetween(0, 19)));
            $manager->persist($idea);
            $this->addReference('idea_' . $i, $idea);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
                UserFixtures::class,
        ];
    }
}
