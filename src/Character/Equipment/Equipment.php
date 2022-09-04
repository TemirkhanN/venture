<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Equipment;

class Equipment
{
    /**
     * @var array<string, EquipmentItem>
     */
    private array $items = [];

    /**
     * @return iterable<EquipmentItem>
     */
    public function list(): iterable
    {
        yield from $this->items;
    }

    public function equip(EquipmentItem $item): void
    {
        $this->items[$item->slot->name] = $item;
    }
}
