<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $comment = new Comment();
        $comment->setAuthor($this->getReference('broyer'));
        $comment->setIdea($this->getReference('linux'));
        $comment->setContent('c \'est parfait c\'est valider');
        $comment->setCreatedAt($faker->dateTimeBetween('-3 years', 'now'));
        $manager->persist($comment);

        $faker = Factory::create();
        $comment = new Comment();
        $comment->setAuthor($this->getReference('broyer'));
        $comment->setIdea($this->getReference('wild'));
        $comment->setContent('merci de penser a répondre au sondage ');
        $comment->setCreatedAt($faker->dateTimeBetween('-3 years', 'now'));
        $manager->persist($comment);

        $faker = Factory::create();
        $comment = new Comment();
        $comment->setAuthor($this->getReference('sarah'));
        $comment->setIdea($this->getReference('wild'));
        $comment->setContent('Je suis pour la formation actuelle est trop courte ');
        $comment->setCreatedAt($faker->dateTimeBetween('-3 years', 'now'));
        $manager->persist($comment);

        $faker = Factory::create();
        for ($i = 0; $i < 119; $i++) {
            $comment = new Comment();
            $comment->setAuthor($this->getReference('author_' . $faker->numberBetween(0, 19)));
            $comment->setIdea($this->getReference('idea_' . $faker->numberBetween(0, 39)));
            $comment->setContent($faker->realTextBetween(160, 500, 2));
            $comment->setCreatedAt($faker->dateTimeBetween('-3 years', 'now'));
            $manager->persist($comment);
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
