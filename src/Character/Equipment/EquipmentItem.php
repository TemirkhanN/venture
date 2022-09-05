<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Equipment;

use TemirkhanN\Venture\Item\Armor;
use TemirkhanN\Venture\Item\Weapon;

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

    public static function weapon(Weapon $weapon): self
    {
        return new self($weapon->name(), $weapon->damage, 0, 0, EquipmentItemSlot::MAIN_HAND);
    }

    public static function bodyArmor(Armor $armor): self
    {
        return new self($armor->name(), 0, $armor->defence, $armor->health, EquipmentItemSlot::BODY);
    }
}
