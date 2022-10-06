<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Inventory;

use TemirkhanN\Venture\Item;

class Inventory
{
    private const STACKABLE_ITEMS_TYPES = [
        Item\Prototype\Consumable::ITEM_TYPE,
        Item\Prototype\Resource::ITEM_TYPE,
        Item\Prototype\Currency::ITEM_TYPE,
    ];

    /**
     * @var array<Slot>
     */
    private array $slots = [];

    private int $lastSlot = 1;

    public function __construct()
    {
        $this->addGold(1);
    }

    public function putItem(Item\Prototype\ItemInterface $item, int $amount)
    {
        if ($this->isStackable($item)) {
            foreach ($this->slots as $index => $slot) {
                if ($slot->item->id()->value() == $item->id()->value()) {
                    $this->slots[$index] = $slot->addAmount($amount);

                    return;
                }
            }
        }

        ++$this->lastSlot;

        $this->slots[$this->lastSlot - 1] = new Slot($this->lastSlot, $item, $amount);
    }

    public function removeGold(int $amount): void
    {
        $gold = Item\Prototype\Currency::gold();
        foreach ($this->slots as $index => $slot) {
            if ($slot->item == $gold) {
                $this->slots[$index] = $slot->removeAmount($amount);

                return;
            }
        }

        throw new \DomainException('There is literally no gold in the inventory');
    }

    public function addGold(int $amount): void
    {
        $this->putItem(Item\Prototype\Currency::gold(), $amount);
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

        if ($amountOfItemsLeft > 0 || $inventorySlot->item == Item\Prototype\Currency::gold()) {
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

    private function isStackable(Item\Prototype\ItemInterface $item): bool
    {
        return in_array($item->type(), self::STACKABLE_ITEMS_TYPES);
    }
}
