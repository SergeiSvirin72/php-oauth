<?php

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

require 'dependencies.php';
require 'doctrine.php';
require 'oauth.php';
require 'settings.php';

return $containerBuilder->build();
