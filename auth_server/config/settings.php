<?php

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    'oauth' => [
        'encryption_key' => 'def000008ced1f6e5cd0d8857f34d905012de245ce6474a15e9c0b84c02d85a215e773f20836daad23a187e4b159084778d2757e51e7123f82bd9b5b06940cb7033468c1',
        'private_key' => __DIR__ . '/../key/private.key',
        'public_key' => __DIR__ . '/../key/public.key',
    ],
    'doctrine' => [
        'dev_mode' => true,
        'metadata_dirs' => [__DIR__ . '/../src/Entity'],
        'connection' => [
            'driver' => 'pdo_sqlite',
            'path' => __DIR__ . '/../db/oauth.sqlite',
        ]
    ],
]);
