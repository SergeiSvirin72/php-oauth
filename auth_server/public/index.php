<?php

declare(strict_types=1);

use App\Handler;
use App\Middleware\ResourceServerMiddleware;
use App\Middleware\ScopeMiddlewareFactory;
use Psr\Container\ContainerInterface;
use Slim\App;

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

/** @var App $app */
$app = $container->get(App::class);

$app->addBodyParsingMiddleware();

/** @var ScopeMiddlewareFactory $scopeMiddlewareFactory */
$scopeMiddlewareFactory = $container->get(ScopeMiddlewareFactory::class);

$app->map(['GET', 'POST'], '/login', [Handler\LoginHandler::class, 'handle'])->setName('login');
$app->get('/logout', [Handler\LogoutHandler::class, 'handle'])->setName('logout');
$app->map(['GET', 'POST'], '/authorize', [Handler\AuthorizeHandler::class, 'handle'])->setName('authorize');
$app->post('/access_token', [Handler\AccessTokenHandler::class, 'handle'])->setName('access_token');
$app->get('/resource', [Handler\ResourceHandler::class, 'handle'])
    ->add($scopeMiddlewareFactory->create(['user:main']))
    ->add(ResourceServerMiddleware::class)
    ->setName('resource')
;

$app->run();
