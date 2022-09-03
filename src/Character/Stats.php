<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

class Stats
{
    public int $currentHealth;

    public function __construct(
        public readonly int $attack,
        public readonly int $defence,
        public readonly int $maxHealth,
        public readonly int $attackSpeed = 1
    ) {
        $this->currentHealth = $this->maxHealth;
    }

    public static function lowestStats(): self
    {
        return new self(1, 0, 5);
    }

    public function decreaseHealth(int $amount): void
    {
        $this->currentHealth -= $amount;
    }
}
