<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Character\Stats\EquipmentBoostedStats;
use TemirkhanN\Venture\Character\Stats\LevelBoostedStats;
use TemirkhanN\Venture\Item;
use TemirkhanN\Venture\Player\Inventory;

trait CharacterTrait
{
    private int $exp = 0;
    private string $name;
    private Equipment\Equipment $equipment;
    private Stats $stats;
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
        return new EquipmentBoostedStats($this->equipment, new LevelBoostedStats($this->lvl(), $this->stats));
    }

    public function loseHp(int $amount): void
    {
        if ($amount < 0) {
            throw new \UnexpectedValueException('Can not decrease health by the negative amount');
        }

        $this->stats()->loseHealth($amount);
    }

    public function restoreHp(?int $amount = null): void
    {
        if ($amount === null) {
            $amount = $this->stats()->maxHealth() - $this->stats()->currentHealth();
        }

        if ($amount < 0) {
            throw new \UnexpectedValueException('Can not increase health by the negative amount');
        }

        $this->stats()->restoreHealth($amount);
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
                    $this->restoreHp($effect->power());
                }
            }

            $this->discardItem($fromSlot);
        }
    }

    public function lvl(): int
    {
        return ExperienceCalculator::calculateLvl($this->exp);
    }

    public function exp(): int
    {
        return $this->exp;
    }

    public function nextLvlExp(): int
    {
        return ExperienceCalculator::calculateExp($this->lvl() + 1);
    }
}
