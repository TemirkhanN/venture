<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Equipment;

use TemirkhanN\Venture\Utils\Generic\ImmutableList;

class Equipment
{
    /**
     * @var array<string, EquipmentItem>
     */
    private array $items = [];

    /**
     * @return ImmutableList<EquipmentItem>
     */
    public function list(): ImmutableList
    {
        return new ImmutableList($this->items);
    }

    public function equip(EquipmentItem $item): void
    {
        $this->items[$item->slot->name] = $item;
    }
}
