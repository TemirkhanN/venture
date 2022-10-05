<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Utils;

class Iterating
{
    public static function toArray(iterable $iterable): array
    {
        if (is_array($iterable)) {
            return $iterable;
        }

        $data = [];

        foreach ($iterable as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }
}
