<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft;

class CraftResult
{
    public function __construct(private readonly ItemId $itemId, private readonly int $amount = 1)
    {

    }

    public function item(): ItemId
    {
        return $this->itemId;
    }

    public function amount(): int
    {
        return $this->amount;
    }
}
