<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Equipment;

use TemirkhanN\Generic\Collection\Collection;
use TemirkhanN\Generic\Collection\CollectionInterface;

class Equipment
{
    /**
     * @var array<string, EquipmentItem>
     */
    private array $items = [];

    /**
     * @return CollectionInterface<EquipmentItem>
     */
    public function list(): CollectionInterface
    {
        return new Collection($this->items);
    }

    public function equip(EquipmentItem $item): void
    {
        $this->items[$item->slot->name] = $item;
    }
}
