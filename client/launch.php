<?php

declare(strict_types=1);

use TemirkhanN\Venture\Game\Launcher\WebLauncher;

ini_set('memory_limit','10M');

echo 'Launching...' . PHP_EOL;

require_once __DIR__ . '/../bootstrap.php';

$di = require __DIR__ .'/di.php';

/** @var \TemirkhanN\Venture\Game\Launcher\WebLauncher $launcher */
$launcher = $di->get(WebLauncher::class);

$launcher->run('172.17.0.2:8080');

echo 'Running...' . PHP_EOL;
