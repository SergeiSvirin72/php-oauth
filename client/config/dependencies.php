<?php

use Psr\Container\ContainerInterface;

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    \App\Handler\CallbackHandler::class => function (ContainerInterface $c) {
        $settings = $c->get('oauth');

        return new \App\Handler\CallbackHandler(
            $c->get(\App\Service\HttpClient::class),
            $c->get(\App\Service\SessionManager::class),
            $settings['auth_server_container'],
            $settings['client_id'],
            $settings['client_secret'],
        );
    },
    \App\Handler\LoginHandler::class => function (ContainerInterface $c) {
        $settings = $c->get('oauth');

        return new \App\Handler\LoginHandler(
            $c->get(\App\Service\SessionManager::class),
            $settings['auth_server_url'],
            $settings['client_id'],
        );
    },
    \App\Handler\RefreshHandler::class => function (ContainerInterface $c) {
        $settings = $c->get('oauth');

        return new \App\Handler\RefreshHandler(
            $c->get(\App\Service\HttpClient::class),
            $c->get(\App\Service\SessionManager::class),
            $settings['auth_server_container'],
            $settings['client_id'],
            $settings['client_secret'],
        );
    },
    \App\Handler\ResourceHandler::class => function (ContainerInterface $c) {
        $settings = $c->get('oauth');

        return new \App\Handler\ResourceHandler(
            $c->get(\App\Service\HttpClient::class),
            $c->get(\App\Service\SessionManager::class),
            $settings['auth_server_container'],
        );
    },
    \Slim\Views\PhpRenderer::class => function () {
        return new \Slim\Views\PhpRenderer(__DIR__ . '/../template');
    },
    \Psr\Http\Message\StreamFactoryInterface::class => function () {
        return new \Slim\Psr7\Factory\StreamFactory();
    },
    \Psr\Http\Message\ResponseFactoryInterface::class => function () {
        return new \Slim\Psr7\Factory\ResponseFactory();
    }
]);
