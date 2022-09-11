<?php

declare(strict_types=1);

use TemirkhanN\Venture\Game\App;

require_once __DIR__ . '/../bootstrap.php';

$di = require __DIR__ .'/di.php';

/** @var App $app */
$app = $di->get(App::class);
$app->run();
