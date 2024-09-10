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
        $this->createUser($manager, 'admin@example.com', ['ROLE_ADMIN'], 'admin_password');
        $this->createUser($manager, 'user@example.com', ['ROLE_USER'], 'user_password');

        $manager->flush();
    }

    private function createUser(ObjectManager $manager, string $email, array $roles, string $password): void
    {
        $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$existingUser) {
            $user = new User();
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));

            $manager->persist($user);
        }
    }
}
