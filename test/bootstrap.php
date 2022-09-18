<?php

declare(strict_types=1);

use TemirkhanN\Venture\Utils\Cache;

require_once __DIR__ .'/../bootstrap.php';
require_once __DIR__ .'/output.php';

function getCache(): Cache {
    static $cache = null;

    if ($cache === null) {
        $cache = new Cache('test');
    }

    return $cache;
}
