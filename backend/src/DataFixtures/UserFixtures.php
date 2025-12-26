<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'id' => Uuid::v7(),
                'email' => 'luciano@griffith.com',
                'password' => 'test123'
            ],
            [
                'id' => Uuid::v7(),
                'email' => 'test@test.com',
                'password' => 'test123'
            ],
            [
                'id' => Uuid::v7(),
                'email' => 'john@doe.com',
                'password' => 'test123'
            ],
        ];

        foreach ($data as $user) {
            $table = new User();
            $table->setId($user['id']);
            $table->setEmail($user['email']);
            $table->setPassword($user['password']);

            $manager->persist($table);
        }

        $manager->flush();
    }
}
