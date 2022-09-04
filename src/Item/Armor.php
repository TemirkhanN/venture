<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

class Armor
{
    public function __construct(
        public readonly string $name,
        public readonly int $defence,
        public readonly int $health = 0
    )
    {

    }
}
