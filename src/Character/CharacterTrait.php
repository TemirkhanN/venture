<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Item;
use TemirkhanN\Venture\Player\Inventory;

trait CharacterTrait
{
    private string $name;
    private Equipment\Equipment $equipment;
    private StatsInterface $stats;
    private Inventory\Inventory $inventory;

    public function name(): string
    {
        return $this->name;
    }

    public function isAlive(): bool
    {
        return $this->stats()->currentHealth() > 0;
    }

    public function stats(): StatsInterface
    {
        return new EquipmentBoostedStats($this->equipment, $this->stats);
    }

    public function decreaseHealth(int $amount): void
    {
        if ($amount < 0) {
            throw new \UnexpectedValueException('Can not decrease health by the negative amount');
        }

        $this->stats->decreaseHealth($amount);
    }

    public function increaseHealth(int $amount): void
    {
        if ($amount < 0) {
            throw new \UnexpectedValueException('Can not increase health by the negative amount');
        }

        $this->stats->increaseHealth($amount);
    }


    /**
     * @return iterable<Inventory\Slot>
     */
    public function showInventory(): iterable
    {
        return $this->inventory->list();
    }

    public function equip(Equipment\EquipmentItem $item): void
    {
        $this->equipment->equip($item);
    }

    public function canEquip(Item\ItemInterface $item): bool
    {
        return EquipmentItem::isEquipmentItem($item);
    }

    /**
     * @return iterable<Equipment\EquipmentItem>
     */
    public function equipment(): iterable
    {
        return $this->equipment->list();
    }

    public function canUseItem(Item\ItemInterface $item): bool
    {
        if ($item->type() === Item\Consumable::ITEM_TYPE) {
            return true;
        }

        return false;
    }

    public function discardItem(Inventory\Slot $slot): void
    {
        $this->inventory->removeItem($slot);
    }

    public function useItem(Inventory\Slot $fromSlot): void
    {
        if (!$this->canUseItem($fromSlot->item)) {
            throw new \DomainException('Character can not use this item');
        }

        $item = $fromSlot->item;

        if ($this->canEquip($item)) {
            $this->equip(EquipmentItem::autoDetect($item));

            return;
        }

        if ($item instanceof Item\Consumable) {
            foreach ($item->effects() as $effect) {
                if ($effect->type() == Item\Effect\EffectType::FAST_HEAL) {
                    $this->increaseHealth($effect->power());
                }
            }

            $this->discardItem($fromSlot);
        }
    }
}
