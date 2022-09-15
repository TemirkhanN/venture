<?php

declare(strict_types=1);

use TemirkhanN\Venture\Game\App;
use TemirkhanN\Venture\Game\IO\HttpInput;
use TemirkhanN\Venture\Game\IO\Printer;

ini_set('memory_limit','10M');

require_once __DIR__ . '/../bootstrap.php';

$di = require __DIR__ .'/di.php';

/** @var App $app */
$app = $di->get(App::class);

$app->run(HttpInput::json(), new Printer());
