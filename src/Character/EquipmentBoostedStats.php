<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

class EquipmentBoostedStats implements StatsInterface
{
    private readonly StatsInterface $baseStats;
    private readonly Equipment\Equipment $equipment;

    public function __construct(Equipment\Equipment $equipment, StatsInterface $baseStats)
    {
        $this->baseStats = $baseStats;
        $this->equipment = $equipment;
    }

    public function attack(): int
    {
        $attack = $this->baseStats->attack();

        foreach ($this->equipment->list() as $item) {
            $attack += $item->attack;
        }

        return $attack;
    }

    public function defence(): int
    {
        $defence = $this->baseStats->defence();
        foreach ($this->equipment->list() as $item) {
            $defence += $item->defence;
        }

        return $defence;
    }

    public function maxHealth(): int
    {
        $maxHealth = $this->baseStats->maxHealth();

        foreach ($this->equipment->list() as $item) {
            $maxHealth += $item->health;
        }

        return $maxHealth;
    }

    public function currentHealth(): int
    {
        $currentHealth = $this->baseStats->currentHealth();

        foreach ($this->equipment->list() as $item) {
            $currentHealth += $item->health;
        }

        return $currentHealth;
    }

    public function decreaseHealth(int $amount): void
    {
        $this->baseStats->decreaseHealth($amount);
    }
}
