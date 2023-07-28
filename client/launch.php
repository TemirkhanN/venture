<?php

declare(strict_types=1);

use GameClient\Launcher\WebLauncher;

ini_set('memory_limit','10M');

$host = '172.17.0.2';
if (isset($argv[1])) {
    $host = $argv[1];
}

echo 'Launching...' . PHP_EOL;

require_once __DIR__ . '/../bootstrap.php';

$di = require __DIR__ .'/di.php';

/** @var \GameClient\Launcher\WebLauncher $launcher */
$launcher = $di->get(WebLauncher::class);

$launcher->run($host . ':8080');

echo 'Running...' . PHP_EOL;
