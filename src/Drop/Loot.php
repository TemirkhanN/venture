<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Drop;

use TemirkhanN\Venture\Item\ItemInterface;

class Loot
{
    public function __construct(
        public readonly ItemInterface $item,
        public readonly int $amount
    )
    {

    }
}
