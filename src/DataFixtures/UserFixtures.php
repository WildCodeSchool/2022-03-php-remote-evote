<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
     * UserFixtures constructor.
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user =new User();
        $user->setEmail('user@wcs.com');
        $user->setFirstname('User');
        $user->setLastname('User');
        $user->setPassword($this->passwordHasher->hashPassword($user,'password'));
        $manager->persist($user);
        $manager->flush();
    }
}
