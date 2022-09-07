<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Inventory;

use TemirkhanN\Venture\Item;

class Inventory
{
    /**
     * @var iterable<Slot>
     */
    private array $slots = [];

    private int $lastSlot = 1;

    public function __construct()
    {
        $this->putItem(Item\Currency::gold(), 0);
    }

    public function putItem(Item\ItemInterface $item, int $amount)
    {
        if ($item == Item\Currency::gold()) {
            $currentGoldAmount = $this->slots[0]->amountOfItems ?? 0;

            $this->slots[0] = new Slot(1, $item, $currentGoldAmount + $amount);

            return;
        }

        ++$this->lastSlot;

        $this->slots[$this->lastSlot - 1] = new Slot($this->lastSlot, $item, $amount);
    }

    /**
     * @return array<Slot>
     */
    public function list(): array
    {
        return $this->slots;
    }
}
