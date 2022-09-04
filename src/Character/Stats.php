<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

class Stats implements StatsInterface
{
    private int $currentHealth;

    public function __construct(
        private readonly int $attack,
        private readonly int $defence,
        private readonly int $maxHealth
    ) {
        $this->currentHealth = $this->maxHealth;
    }

    public static function lowestStats(): self
    {
        return new self(1, 0, 5);
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
        if ($amount < 0) {
            throw new \UnexpectedValueException('Can not decrease health by negative amount');
        }

        $this->currentHealth -= $amount;
    }
}
