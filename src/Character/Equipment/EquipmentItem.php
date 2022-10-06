<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Equipment;

use TemirkhanN\Venture\Item\Prototype\Armor;
use TemirkhanN\Venture\Item\Prototype\ItemInterface;
use TemirkhanN\Venture\Item\Prototype\Weapon;

class EquipmentItem
{
    private function __construct(
        public readonly string $name,
        public readonly int $attack,
        public readonly int $defence,
        public readonly int $health,
        public readonly EquipmentItemSlot $slot
    ) {

    }

    public static function isEquipmentItem(ItemInterface $item): bool
    {
        return in_array($item->type(), [Armor::ITEM_TYPE, Weapon::ITEM_TYPE]);
    }

    public static function autoDetect(ItemInterface $item): self
    {
        if ($item instanceof Armor) {
            return self::bodyArmor($item);
        }


        if ($item instanceof Weapon) {
            return self::weapon($item);
        }

        throw new \InvalidArgumentException(
            sprintf('%s is neither armor or weapon but %s', $item->name(), $item->type())
        );
    }

    public static function weapon(Weapon $weapon): self
    {
        return new self($weapon->name(), $weapon->attack, 0, 0, EquipmentItemSlot::MAIN_HAND);
    }

    public static function bodyArmor(Armor $armor): self
    {
        return new self($armor->name(), 0, $armor->defence, $armor->health, EquipmentItemSlot::BODY);
    }
}
