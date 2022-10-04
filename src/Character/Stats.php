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

    public static function lowestStats(int $multiply = 1): self
    {
        if ($multiply < 1) {
            throw new \LogicException('Stats can not be negative');
        }

        return new self(1 * $multiply, 0 * $multiply, 5 * $multiply);
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

    public function loseHealth(int $amount): void
    {
        if ($amount < 0) {
            throw new \UnexpectedValueException('Can not decrease health by negative amount');
        }

        $this->currentHealth -= $amount;

        if ($this->currentHealth < 0) {
            $this->currentHealth = 0;
        }
    }

    public function restoreHealth(int $amount): void
    {
        if ($amount < 0) {
            throw new \UnexpectedValueException('Can not increase health by negative amount');
        }

        $this->currentHealth += $amount;
        if ($this->currentHealth > $this->maxHealth) {
            $this->currentHealth = $this->maxHealth;
        }
    }
}
