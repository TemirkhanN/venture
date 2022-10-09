<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Inventory;

use IteratorAggregate;
use TemirkhanN\Venture\Item;
use TemirkhanN\Venture\Utils\Generic\ImmutableList;
use TemirkhanN\Venture\Utils\Generic\Result;
use Traversable;

class Inventory implements IteratorAggregate
{
    private const STACKABLE_ITEMS_TYPES = [
        Item\Prototype\Consumable::ITEM_TYPE,
        Item\Prototype\Resource::ITEM_TYPE,
        Item\Prototype\Currency::ITEM_TYPE,
    ];

    /**
     * @var array<int, Slot>
     */
    private array $slots = [];

    public function __construct(int $size = 32)
    {
        for ($i = 0; $i < $size; $i++) {
            $this->slots[$i] = Slot::empty($i + 1);
        }
    }

    public function putItem(Item\ItemInterface $item, int $amount): Result
    {
        $firstEmptySlotIndex = null;
        foreach ($this->slots as $index => $slot) {
            if ($slot->isEmpty()) {
                if (!isset($firstEmptySlotIndex)) {
                    $firstEmptySlotIndex = $index;
                }

                if (!$this->isStackable($item)) {
                    $this->slots[$index] = $slot->replace($item, $amount);

                    return Result::success();
                }
            } else {
                if ($this->isStackable($item) && (string)$slot->item->id() === (string)$item->id()) {
                    $this->slots[$index] = $slot->addAmount($amount);

                    return Result::success();
                }
            }
        }

        if ($this->isStackable($item) && $firstEmptySlotIndex !== null) {
            $slot                              = $this->slots[$firstEmptySlotIndex];
            $this->slots[$firstEmptySlotIndex] = $slot->replace($item, $amount);

            return Result::success();
        }

        return Result::error('Inventory is full');
    }

    public function removeItem(int $slotPosition, ?int $amount): Result
    {
        $index = $slotPosition - 1;

        $inventorySlot = $this->getSlot($slotPosition);
        if ($inventorySlot->isEmpty()) {
            return Result::error('There is no such items in the slot');
        }

        $discardingAmount = $amount;
        if ($discardingAmount === null) {
            $discardingAmount = $inventorySlot->amountOfItems;
        }

        if ($inventorySlot->amountOfItems < $discardingAmount) {
            return Result::error('There is no such amount of items in the slot');
        }

        $amountOfItemsLeft = $inventorySlot->amountOfItems - $discardingAmount;

        if ($amountOfItemsLeft > 0 || $inventorySlot->item == Item\Prototype\Currency::gold()) {
            $updatedSlot = new Slot($inventorySlot->position, $inventorySlot->item, $amountOfItemsLeft);
        } else {
            $updatedSlot = Slot::empty($inventorySlot->position);
        }

        $this->slots[$index] = $updatedSlot;

        return Result::success();
    }

    /**
     * @return array<Slot>
     */
    public function slots(): array
    {
        return array_values($this->slots);
    }

    /**
     * @return ImmutableList<Slot>
     */
    public function getIterator(): Traversable
    {
        return new ImmutableList($this->slots());
    }

    public function getSlot(int $position): Slot
    {
        if (!isset($this->slots[$position - 1])) {
            throw new \OverflowException('There is no such slot at position %d', $position);
        }

        return $this->slots[$position - 1];
    }

    private function isStackable(Item\Prototype\ItemInterface $item): bool
    {
        return in_array($item->type(), self::STACKABLE_ITEMS_TYPES);
    }
}
