<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public $users = [];
    public $books = [];
    public $authors = [];
    public $libraries = [];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');


        for ($i = 0; $i < 11; $i++) {
            $user = new User;
            $user->setEmail($faker->email())
                ->setLastname($faker->lastName())
                ->setFirstname($faker->firstName())
                ->setPassword($this->hasher->hashPassword($user, 'password'));

            $users[] = $user;
            $manager->persist($user);
        }
        echo ('Utilisateurs créés');
        echo ('\br');


        for ($i = 0; $i < 11; $i++) {
            $author = new Author;
            $author->setFirstname($faker->firstName())
                ->setLastname($faker->lastName());

            $authors[] = $author;

            $manager->persist($author);
        }
        echo ('Auteurs créés');
        echo ('\br');

        for ($i = 0; $i < 31; $i++) {
            
            $book = new Book;
            $book->setName($faker->word())
                ->setAuthor($authors[rand(1, 10)]);

            $books[] = $book;

            $manager->persist($book);
        }
        echo ('Livrés créés');
        echo ('\br');

        $manager->flush();
    }
}
