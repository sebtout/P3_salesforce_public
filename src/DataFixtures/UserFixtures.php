<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)
        $user = new User();
        $user->setEmail('user@salesforce.com');
        $user->setLastname('User');
        $user->setFirstname('Test');
        $user->setProfession('Sales assistant');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            '123s@lesforce'
        );

        $user->setPassword($hashedPassword);
        $manager->persist($user);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@salesforce.com');
        $admin->setLastname('Admin');
        $admin->setFirstname('Testing');
        $admin->setProfession('IT Manager');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            '123s@lesforce'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        // Création de 20 utilisateurs de type “contributeur” (= auteur)
        $faker = Factory::create();
        for ($i = 0; $i < 13; $i++) {
            $pictures = [
                'adashelby.jpg',
                'cersei.jpg',
                'cillianmurphy.jpg',
                'daenerys.jpg',
                'DrAudreyLim.jpg',
                'DrShaunMurfy.jpg',
                'eleven.jpg',
                'jimhopper.jpg',
                'jonsnow.jpg',
                'joycebyers.jpg',
                'mikewheeler.jpg',
                'pollygrey.jpg',
                'tyrion.jpg',
            ];

            $author = new User();
            $author->setEmail($faker->email());
            $author->setLastname($faker->lastName());
            $author->setFirstname($faker->firstName());
            $author->setProfession($faker->jobTitle());
            $author->setRoles(['ROLE_USER']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $author,
                '123s@lesforce'
            );
            $author->setPassword($hashedPassword);
            $author->setProfilePicture($pictures[$i]);
            $author->setUpdateAt($faker->dateTimeBetween('-3 years', 'now'));
            $manager->persist($author);
            $this->addReference('author_' . $i, $author);
        }

        $faker = Factory::create();
        for ($i = 13; $i < 20; $i++) {
            $authorw = new User();
            $authorw->setEmail($faker->email());
            $authorw->setLastname($faker->lastName());
            $authorw->setFirstname($faker->firstName());
            $authorw->setProfession($faker->jobTitle());
            $authorw->setRoles(['ROLE_USER']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $authorw,
                '123s@lesforce'
            );
            $authorw->setPassword($hashedPassword);
            $manager->persist($authorw);
            $this->addReference('author_' . $i, $authorw);
        }

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}
