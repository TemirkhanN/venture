<?php

declare(strict_types=1);

require_once __DIR__ .'/../bootstrap.php';
require_once __DIR__ .'/output.php';

const MEMORY_DIR = __DIR__ . '/../var/';

function saveDataIntoMemory(string $id, object $object): void {
    $memFile = sprintf('%s/%s.inmem', MEMORY_DIR, $id);

    file_put_contents($memFile, serialize($object));
}

function getDataFromMemory(string $id): ?object {
    $memFile = sprintf('%s/%s.inmem', MEMORY_DIR, $id);

    if (!file_exists($memFile)) {
        return null;
    }

    $contents = file_get_contents($memFile);
    if ($contents === '' || $contents === false) {
        return null;
    }

    return @unserialize($contents);
}
