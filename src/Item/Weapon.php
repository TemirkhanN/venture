<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Item;

class Weapon
{
    public function __construct(
        public readonly string $name,
        public readonly int $damage
    )
    {

    }
}
