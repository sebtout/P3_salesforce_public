<?php

namespace App\DataFixtures;

use App\Entity\IdeaLike;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IdeaLikeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 200; $i++) {
            $ideaLike = new IdeaLike();
            $ideaLike->setUser($this->getReference('author_' . $faker->numberBetween(0, 19)));
            $ideaLike->setIdea($this->getReference('idea_' . $faker->numberBetween(0, 39)));
            $manager->persist($ideaLike);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            IdeaFixtures::class,
        ];
    }
}
