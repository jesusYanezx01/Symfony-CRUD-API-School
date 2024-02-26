<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $roles = [
            ['name' => 'ADMIN', 'description' => 'user with role admin'],
            ['name' => 'STUDENT', 'description' => 'user with role student'],
            ['name' => 'TEACHER', 'description' => 'user with role teacher'],
        ];

        foreach ($roles as $roleData) {
            $role = new Role();
            $role->setName($roleData['name']);
            $role->setDescription($roleData['description']);
            $manager->persist($role);
        }


        $manager->flush();
    }
}
