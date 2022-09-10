<?php

declare(strict_types=1);

use TemirkhanN\Venture\Utils\Cache;

require_once __DIR__ .'/../bootstrap.php';
require_once __DIR__ .'/output.php';

$cache = new Cache('test');

function getCache() use ($cache): Cache {
    return $cache;
}
