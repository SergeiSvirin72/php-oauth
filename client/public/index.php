<?php

declare(strict_types=1);

use App\Handler;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get('/login', [Handler\LoginHandler::class, 'handle']);
$app->get('/callback', [Handler\CallbackHandler::class, 'handle']);
$app->get('/refresh', [Handler\RefreshHandler::class, 'handle']);
$app->get('/resource', [Handler\ResourceHandler::class, 'handle']);
$app->get('/logout', [Handler\LogoutHandler::class, 'handle']);

$app->run();
