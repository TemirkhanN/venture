<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

class EquipmentBoostedStats implements StatsInterface
{
    private readonly int $attack;
    private readonly int $defence;
    private readonly int $maxHealth;
    private int $currentHealth;

    public function __construct(Equipment\Equipment $equipment, StatsInterface $baseStats)
    {
        $attack = $baseStats->attack();
        $defence = $baseStats->defence();
        $maxHealth = $baseStats->maxHealth();
        $currentHealth = $baseStats->currentHealth();
        foreach ($equipment->list() as $item) {
            $attack += $item->attack;
            $defence += $item->defence;
            $maxHealth += $item->health;
        }

        if ($baseStats->currentHealth() === $baseStats->maxHealth()) {
            $currentHealth = $maxHealth;
        }

        $this->attack = $attack;
        $this->defence = $defence;
        $this->maxHealth = $maxHealth;
        $this->currentHealth = $currentHealth;
    }

    public function attack(): int
    {
        return $this->attack;
    }

    public function defence(): int
    {
        return $this->defence;
    }

    public function maxHealth(): int
    {
        return $this->maxHealth;
    }

    public function currentHealth(): int
    {
        return $this->currentHealth;
    }

    public function decreaseHealth(int $amount): void
    {
        $this->currentHealth -= $amount;
        if ($this->currentHealth < 0) {
            $this->currentHealth = 0;
        }
    }

    public function increaseHealth(int $amount): void
    {
        $this->currentHealth += $amount;
        if ($this->currentHealth > $this->maxHealth) {
            $this->currentHealth = $this->maxHealth;
        }
    }
}
