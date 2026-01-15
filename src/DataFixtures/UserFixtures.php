<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
        $user = new User();
        $user->setEmail('user@gmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'user');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $prof = new User();
        $prof->setEmail('prof@gmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($prof, 'prof');
        $prof->setPassword($hashedPassword);
        $prof->setRoles(['ROLE_PROF']);
        $manager->persist($prof);

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($hashedPassword);
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $superAdmin = new User();
        $superAdmin->setEmail('superadmin@gmail.com');
        $hashedPassword = $this->passwordHasher->hashPassword($superAdmin, 'superadmin');
        $superAdmin->setPassword($hashedPassword);
        $superAdmin->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($superAdmin);

        $manager->flush();
    }
}
