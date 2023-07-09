<?php

use Psr\Container\ContainerInterface;

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    \League\OAuth2\Server\AuthorizationServer::class => function (ContainerInterface $c) {
        $authorizationServer = new \League\OAuth2\Server\AuthorizationServer(
            $c->get(\App\Repository\ClientRepository::class),
            $c->get(\App\Repository\AccessTokenRepository::class),
            $c->get(\App\Repository\ScopeRepository::class),
            new \League\OAuth2\Server\CryptKey($c->get('oauth')['private_key']),
            \Defuse\Crypto\Key::loadFromAsciiSafeString($c->get('oauth')['encryption_key']),
        );

        $authCodeGrant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
            $c->get(\App\Repository\AuthCodeRepository::class),
            $c->get(\App\Repository\RefreshTokenRepository::class),
            new \DateInterval('PT10M'),
        );
        $authCodeGrant->setRefreshTokenTTL(new \DateInterval('P1M'));

        $refreshTokenGrant = new \League\OAuth2\Server\Grant\RefreshTokenGrant(
            $c->get(\App\Repository\RefreshTokenRepository::class),
        );
        $refreshTokenGrant->setRefreshTokenTTL(new \DateInterval('P1M'));

        $authorizationServer->enableGrantType($authCodeGrant, new \DateInterval('PT1H'));
        $authorizationServer->enableGrantType($refreshTokenGrant, new \DateInterval('PT1H'));

        return $authorizationServer;
    },
    \League\OAuth2\Server\ResourceServer::class => function (ContainerInterface $c) {
        return new \League\OAuth2\Server\ResourceServer(
            $c->get(\App\Repository\AccessTokenRepository::class),
            $c->get('oauth')['public_key'],
        );
    },
]);
