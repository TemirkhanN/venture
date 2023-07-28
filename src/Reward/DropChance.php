<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Reward;

use TemirkhanN\Venture\Utils\Id;

readonly class DropChance
{
    public function __construct(public Id $item, public int $amount, public float $chance)
    {
    }
}
