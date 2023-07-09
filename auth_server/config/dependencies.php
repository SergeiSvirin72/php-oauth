<?php

use Psr\Container\ContainerInterface;

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    \Slim\App::class => function (ContainerInterface $container) {
        \Slim\Factory\AppFactory::setContainer($container);

        return \Slim\Factory\AppFactory::create();
    },
    \Slim\Interfaces\RouteParserInterface::class => function (ContainerInterface $container) {
        return $container->get(\Slim\App::class)->getRouteCollector()->getRouteParser();
    },
    \Slim\Views\PhpRenderer::class => function () {
        return new \Slim\Views\PhpRenderer(__DIR__ . '/../template');
    },
    \Psr\Http\Message\ResponseFactoryInterface::class => function () {
        return new \Slim\Psr7\Factory\ResponseFactory();
    }
]);
