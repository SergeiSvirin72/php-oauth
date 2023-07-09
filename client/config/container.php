<?php

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

require 'dependencies.php';
require 'settings.php';

return $containerBuilder->build();
