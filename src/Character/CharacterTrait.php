<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

trait CharacterTrait
{
    private string $name;
    private Equipment\Equipment $equipment;
    private Stats $stats;

    public function name(): string
    {
        return $this->name;
    }

    public function isAlive(): bool
    {
        return $this->stats()->currentHealth() !== 0;
    }

    public function stats(): StatsInterface
    {
        return new EquipmentBoostedStats($this->equipment, $this->stats);
    }

    public function equip(Equipment\EquipmentItem $item): void
    {
        $this->equipment->equip($item);
    }
}
