<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Equipment;

use TemirkhanN\Venture\Item;
use TemirkhanN\Venture\Utils\Id;
use TemirkhanN\Venture\Utils\InstanceTrait;

class EquipmentItem
{
    use InstanceTrait;

    private function __construct(
        public readonly Id $id,
        public readonly string $name,
        public readonly int $attack,
        public readonly int $defence,
        public readonly int $health,
        public readonly EquipmentItemSlot $slot
    ) {
        $this->instanceId = $id;

    }

    public static function isEquipmentItem(Item\Prototype\ItemInterface $item): bool
    {
        return in_array($item->type(), [Item\Prototype\Armor::ITEM_TYPE, Item\Prototype\Weapon::ITEM_TYPE]);
    }

    public static function autoDetect(Item\ItemInterface $item): self
    {
        if ($item instanceof Item\Armor) {
            return self::bodyArmor($item);
        }


        if ($item instanceof Item\Weapon) {
            return self::weapon($item);
        }

        throw new \InvalidArgumentException(
            sprintf('%s is neither armor or weapon but %s', $item->name(), $item->type())
        );
    }

    public static function weapon(Item\Weapon $weapon): self
    {
        return new self($weapon->instanceId(), $weapon->name(), $weapon->attack(), 0, 0, EquipmentItemSlot::MAIN_HAND);
    }

    public static function bodyArmor(Item\Armor $armor): self
    {
        return new self(
            $armor->instanceId(), $armor->name(), 0, $armor->defence(), $armor->health(), EquipmentItemSlot::BODY
        );
    }
}
