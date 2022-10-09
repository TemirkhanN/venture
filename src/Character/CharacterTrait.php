<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

use TemirkhanN\Venture\Character\Equipment\EquipmentItem;
use TemirkhanN\Venture\Character\Stats\EquipmentBoostedStats;
use TemirkhanN\Venture\Character\Stats\LevelBoostedStats;
use TemirkhanN\Venture\Drop\Loot;
use TemirkhanN\Venture\Item;
use TemirkhanN\Venture\Player\Inventory;
use TemirkhanN\Venture\Utils\Generic\ImmutableList;
use TemirkhanN\Venture\Utils\Generic\Result;

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

    public function showInventory(): Inventory\Inventory
    {
        return $this->inventory;
    }

    // todo check if it is necessary to expose this
    public function slot(int $slotPosition): Inventory\Slot
    {
        return $this->inventory->getSlot($slotPosition);
    }

    public function equip(Equipment\EquipmentItem $item): void
    {
        $this->equipment->equip($item);
    }

    public function canEquip(Item\Prototype\ItemInterface $item): bool
    {
        return EquipmentItem::isEquipmentItem($item);
    }

    /**
     * @return ImmutableList<Equipment\EquipmentItem>
     */
    public function equipment(): ImmutableList
    {
        return $this->equipment->list();
    }

    public function canUseItem(int $slotPosition): bool
    {
        $slot = $this->inventory->getSlot($slotPosition);
        if ($slot->isEmpty()) {
            return false;
        }

        if ($slot->item->type() === Item\Prototype\Consumable::ITEM_TYPE) {
            return true;
        }

        return false;
    }

    public function discardItem(int $slotPosition, ?int $amount = null): Result
    {
        return $this->inventory->removeItem($slotPosition, $amount);
    }

    public function loot(Loot $loot): Result
    {
        return $this->inventory->putItem($loot->item, $loot->amount);
    }

    public function useItem(int $inSlot, int $amount): Result
    {
        if (!$this->canUseItem($inSlot)) {
            return Result::error('Character can not use this item');
        }

        $slot = $this->inventory->getSlot($inSlot);
        $item = $slot->item;

        if ($this->canEquip($item)) {
            $this->equip(EquipmentItem::autoDetect($item));

            return Result::success('Equipped item');
        }

        if ($item->type() === Item\Prototype\Consumable::ITEM_TYPE) {
            foreach ($item->effects() as $effect) {
                if ($effect->type() == Item\Effect\EffectType::FAST_HEAL) {
                    $this->restoreHp($effect->power());
                }
            }

            $this->discardItem($inSlot, 1);

            return Result::success('Consumed item');
        }

        return Result::error('Could not use the item.');
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
