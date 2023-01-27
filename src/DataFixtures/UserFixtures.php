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
        $samples = [
            ['email' => 'user@salesforce.com', 'lastname' => 'User', 'firstname' => 'Test',
                'profession' => 'Sales assistant', 'roles' => 'ROLE_USER', 'password' => '123s@lesforce',
                'reference' => 'user'],
            ['email' => 'admin@salesforce.com', 'lastname' => 'Admin', 'firstname' => 'Testing',
                'profession' => 'IT Manager', 'roles' => 'ROLE_ADMIN', 'password' => '123s@lesforce',
                'reference' => 'admin'],
            ['email' => 'broyerdamien@gmail.com', 'lastname' => 'Broyer', 'firstname' => 'Damien',
                'profession' => 'Développeur web', 'roles' => 'ROLE_USER', 'password' => 'damienbroyer',
                'reference' => 'broyer'],
            ['email' => 'sarahcroche@gmail.com', 'lastname' => 'Sarah', 'firstname' => 'Croche',
                'profession' => 'Standardiste', 'roles' => 'ROLE_USER', 'password' => 'saracroche/script',
                'reference' => 'sarah'],
            ['email' => 'chuchnorris.com', 'lastname' => 'Chuck', 'firstname' => 'Norris',
                'profession' => 'Dieu de la vie', 'roles' => 'ROLE_ADMIN',
                'password' => '<script>je_suis_le_meilleur</script>', 'reference' => 'chuck'],
        ];
        foreach ($samples as $sample) {
            $user = new User();
            $user->setEmail($sample['email']);
            $user->setLastname($sample['lastname']);
            $user->setFirstname($sample['firstname']);
            $user->setProfession($sample['profession']);
            $user->setRoles([$sample['roles']]);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $sample['password']);
            $user->setPassword($hashedPassword);
            $manager->persist($user);
            $this->addReference($sample['reference'], $user);
        }

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
            $hashedPassword = $this->passwordHasher->hashPassword($author, '123s@lesforce');
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
            $hashedPassword = $this->passwordHasher->hashPassword($authorw, '123s@lesforce');
            $authorw->setPassword($hashedPassword);
            $manager->persist($authorw);
            $this->addReference('author_' . $i, $authorw);
        }

        $manager->flush();
    }
}
