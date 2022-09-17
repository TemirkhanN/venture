<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Item;
use TemirkhanN\Venture\Player\Inventory\Inventory;

trait CharacterTrait
{
    private string $name;
    private Equipment\Equipment $equipment;
    private StatsInterface $stats;
    private Inventory $inventory;

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

    public function useItem(Item\ItemInterface $item): void
    {
        if (!$this->canUseItem($item)) {
            throw new \DomainException('Character can not use this item');
        }

        if (!$item instanceof ITem\Consumable) {
            return;
        }

        foreach ($item->effects() as $effect) {
            if ($effect->type() == Item\Effect\EffectType::FAST_HEAL) {
                $this->increaseHealth($effect->power());
            }
        }
    }
}
