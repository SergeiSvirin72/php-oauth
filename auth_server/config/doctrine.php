<?php

use Psr\Container\ContainerInterface;

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    \Doctrine\ORM\EntityManagerInterface::class => function (ContainerInterface $c) {
        $settings = $c->get('doctrine');

        $connection = \Doctrine\DBAL\DriverManager::getConnection($settings['connection']);
        $config = \Doctrine\ORM\ORMSetup::createAttributeMetadataConfiguration(
            $settings['metadata_dirs'],
            true,
        );

        return new \Doctrine\ORM\EntityManager($connection, $config);
    },
    \App\Repository\AccessTokenRepository::class => function (ContainerInterface $c) {
        return $c->get(\Doctrine\ORM\EntityManagerInterface::class)->getRepository(\App\Entity\AccessToken::class);
    },
    \App\Repository\AuthCodeRepository::class => function (ContainerInterface $c) {
        return $c->get(\Doctrine\ORM\EntityManagerInterface::class)->getRepository(\App\Entity\AuthCode::class);
    },
    \App\Repository\ClientRepository::class => function (ContainerInterface $c) {
        return $c->get(\Doctrine\ORM\EntityManagerInterface::class)->getRepository(\App\Entity\Client::class);
    },
    \App\Repository\RefreshTokenRepository::class => function (ContainerInterface $c) {
        return $c->get(\Doctrine\ORM\EntityManagerInterface::class)->getRepository(\App\Entity\RefreshToken::class);
    },
    \App\Repository\ScopeRepository::class => function (ContainerInterface $c) {
        return $c->get(\Doctrine\ORM\EntityManagerInterface::class)->getRepository(\App\Entity\Scope::class);
    },
    \App\Repository\UserRepository::class => function (ContainerInterface $c) {
        return $c->get(\Doctrine\ORM\EntityManagerInterface::class)->getRepository(\App\Entity\User::class);
    },
]);
