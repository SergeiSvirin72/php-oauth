<?php

use Psr\Container\ContainerInterface;

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    'oauth' => [
        'auth_server_url' => 'http://localhost:8080',
        'auth_server_container' => 'auth_server:8080',
        'client_id' => '9932c43f-60ed-4fd2-a9bc-27da60340652',
        'client_secret' => 'ddeab447f6cd8c19e7569876dcaee009s',
    ]
]);
