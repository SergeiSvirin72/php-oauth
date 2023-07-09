<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Entity\Client;
use App\Entity\Scope;
use App\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class DataLoader implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setIdentifier((string) Uuid::uuid4());
            $user->setEmail('sergei@svirin' . $i . '.ru');
            $user->setPassword(password_hash('1234', null));
            $manager->persist($user);
        }

        $scope = new Scope();
        $scope->setIdentifier('user:main');
        $manager->persist($scope);

        $scope = new Scope();
        $scope->setIdentifier('user:additional');
        $manager->persist($scope);

        $client = new Client();
        $client->setIdentifier('9932c43f-60ed-4fd2-a9bc-27da60340652');
        $client->setName('Client 1');
        $client->setIsConfidential(true);
        $client->setSecret('ddeab447f6cd8c19e7569876dcaee009s');
        $client->setRedirectUri('http://localhost:8081/callback');
        $manager->persist($client);

        $manager->flush();
    }
}
