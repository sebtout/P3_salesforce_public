<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Idea;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IdeaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $idea = new Idea();
        $idea->setTitle('Frite');
        $idea->setContent('Je propose que des frites soit proposés une fois par semaine à la cantine');
        $idea->setStatus('in progress');
        $idea->setAuthor($this->getReference('chuck'));
        $manager->persist($idea);

        $idea = new Idea();
        $idea->setTitle('Symfony devrait étre traduit en français');
        $idea->setContent('Je propose de faire un courrier pour que symfony soit traduit en francais');
        $idea->setStatus('in progress');
        $idea->setAuthor($this->getReference('chuck'));
        $manager->persist($idea);

        $idea = new Idea();
        $idea->setTitle('passer à linux');
        $idea->setContent('Je pense que npus devrions tous passer sur linux , 
        pour que tous le monde monte en compétence ');
        $idea->setStatus('in progress');
        $idea->setAuthor($this->getReference('broyer'));
        $manager->persist($idea);
        $this->addReference('linux', $idea);


        $idea = new Idea();
        $idea->setTitle('formation Wild');
        $idea->setContent('Nous devons passer le temps de formation à la wild aà 12 mois ');
        $idea->setStatus('in progress');
        $idea->setAuthor($this->getReference('broyer'));
        $manager->persist($idea);
        $this->addReference('wild', $idea);

        $idea = new Idea();
        $idea->setTitle('Commencer plus tôt le matin');
        $idea->setContent('Que penser vous de commencer a 8h le matin et finir à 16h30 ');
        $idea->setStatus('in progress');
        $idea->setAuthor($this->getReference('broyer'));
        $manager->persist($idea);


        $idea = new Idea();
        $idea->setTitle('Distibution de bonbon une fois par mois');
        $idea->setContent('Tout le monde est maigrichon , je propose une distribution de bonbon 1 fois par mois ');
        $idea->setStatus('in progress');
        $idea->setAuthor($this->getReference('sarah'));
        $manager->persist($idea);

        $idea = new Idea();
        $idea->setTitle('Mario Kart');
        $idea->setContent('Nous  avons envie d\'organiser un championnat  de Mario kart en interne  
        le mois prochain en equipe aléatoire pour une meilleur cohésion d\'equipe');
        $idea->setStatus('in progress');
        $idea->setAuthor($this->getReference('sarah'));
        $manager->persist($idea);

        $faker = Factory::create();
        for ($i = 0; $i < 40; $i++) {
            $idea = new Idea();
            $idea->setTitle($faker->realText(40, 2));
            $idea->setContent($faker->realTextBetween(160, 500, 2));
            $idea->setStatus('in progress');
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
