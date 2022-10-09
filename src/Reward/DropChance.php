<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Reward;

use TemirkhanN\Venture\Utils\Id;

class DropChance
{
    public function __construct(public readonly Id $item, public readonly int $amount, public readonly float $chance)
    {
    }
}
