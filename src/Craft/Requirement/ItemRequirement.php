<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Craft\Requirement;

use TemirkhanN\Venture\Craft\ItemId;

class ItemRequirement
{
    public function __construct(private readonly ItemId $item, private readonly int $amount)
    {
        if ($amount < 1) {
            throw new \LogicException('Required amount can not be lesser than 1');
        }
    }

    public function item(): ItemId
    {
        return $this->item;
    }

    public function amount(): int
    {
        return $this->amount;
    }
}
