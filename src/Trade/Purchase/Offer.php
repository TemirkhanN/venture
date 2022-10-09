<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Trade\Purchase;

use TemirkhanN\Venture\Item\Prototype\ItemInterface;
use TemirkhanN\Venture\Utils\Id;

class Offer
{
    /** @var array<Requirement> */
    private array $requirements = [];

    public function isEmpty(): bool
    {
        return $this->requirements === [];
    }

    public function require(ItemInterface $item, int $amount): void
    {
        $this->requirements[] = new Requirement($item, $amount);
    }

    /**
     * @return iterable<Requirement>
     */
    public function requirements(): iterable
    {
        return $this->requirements;
    }
}
