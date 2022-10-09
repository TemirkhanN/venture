<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Trade\Purchase;

use TemirkhanN\Venture\Item\Prototype\ItemInterface;
use TemirkhanN\Venture\Utils\Id;

class Requirement
{
    private readonly int $amount;
    private readonly ItemInterface $item;

    public function __construct(ItemInterface $item, int $amount)
    {
        if ($amount < 1) {
            throw new \LogicException('Price requirement can not be less than 1');
        }

        $this->amount          = $amount;
        $this->item = $item;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function item(): ItemInterface
    {
        return $this->item;
    }
}
