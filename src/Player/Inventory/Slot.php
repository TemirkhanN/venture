<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Inventory;

use TemirkhanN\Venture\Item\ItemInterface;

class Slot
{
    public function __construct(
        public readonly int $position,
        public readonly ItemInterface $item,
        public readonly int $amountOfItems
    )
    {

    }
}
