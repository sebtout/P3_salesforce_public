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

        $user = new User();
        $user->setEmail('broyerdamien@gmail.com');
        $user->setLastname('Broyer');
        $user->setFirstname('Damien');
        $user->setProfession('Développeur web');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'damienbroyer'
        );

        $user->setPassword($hashedPassword);
        $manager->persist($user);
        $this->addReference('broyer', $user);


        $user = new User();
        $user->setEmail('sarahcroche@gmail.com');
        $user->setLastname('Sarah');
        $user->setFirstname('Croche');
        $user->setProfession('Standardiste');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'saracroche/script'
        );

        $user->setPassword($hashedPassword);
        $manager->persist($user);
        $this->addReference('sarah', $user);


        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $admin3 = new User();
        $admin3->setEmail('chuchnorris.com');
        $admin3->setLastname('Chuck');
        $admin3->setFirstname('Norris');
        $admin3->setProfession('Dieu de la vie');
        $admin3->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin3,
            '<script>je_suis_le_meilleur</script>'
        );
        $admin3->setPassword($hashedPassword);
        $manager->persist($admin3);
        $this->addReference('chuck', $admin3);

        // Création de 20 utilisateurs de type “contributeur” (= auteur)
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
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
            $manager->persist($author);
            $this->addReference('author_' . $i, $author);
        }
        $manager->flush();
    }
}
