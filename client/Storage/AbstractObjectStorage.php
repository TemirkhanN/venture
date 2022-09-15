<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Storage;

use RuntimeException;
use TemirkhanN\Venture\Utils\Cache;

abstract class AbstractObjectStorage
{
    public function __construct(private readonly Cache $cache)
    {

    }

    protected function getObject(string $key, string $instanceClass): ?object
    {
        $object = $this->cache->get($key);

        if ($object === null) {
            return null;
        }

        if (!is_object($object)) {
            throw new RuntimeException(sprintf('%s expected to be object', gettype($object)));
        }

        if (!$object instanceof $instanceClass) {
            throw new RuntimeException(sprintf('%s expected to be %s instance', get_class($object), $instanceClass));
        }

        return $object;
    }

    protected function saveObject(string $key, object $object): void
    {
        $this->cache->save($key, $object);
    }
}
