<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Inventory;

use TemirkhanN\Venture\Item;

class Inventory
{
    /**
     * @var array<Slot>
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

    public function removeItem(Slot $fromSlot): void
    {
        $index = $fromSlot->position - 1;

        $inventorySlot = $this->slots[$index] ?? null;
        // There is no such item
        if ($inventorySlot === null) {
            throw new \UnexpectedValueException('There is no such items in the slot');
        }

        if ($inventorySlot->item->name() !== $fromSlot->item->name()) {
            throw new \UnexpectedValueException('There is no such items in the slot');
        }

        if ($inventorySlot->amountOfItems < $fromSlot->amountOfItems) {
            throw new \UnexpectedValueException('There is no such amount of items in the slot');
        }

        $amountOfItemsLeft = $inventorySlot->amountOfItems - $fromSlot->amountOfItems;

        if ($amountOfItemsLeft > 0 || $inventorySlot->item == Item\Currency::gold()) {
            $this->slots[$index] = new Slot($inventorySlot->position, $inventorySlot->item, $amountOfItemsLeft);
        } else {
            unset($this->slots[$index]);
        }
    }

    /**
     * @return array<Slot>
     */
    public function list(): array
    {
        return $this->slots;
    }
}
