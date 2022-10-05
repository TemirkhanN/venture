<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Stats;

use TemirkhanN\Venture\Character\Stats;
use TemirkhanN\Venture\Character\StatsInterface;

class LevelBoostedStats implements StatsInterface
{
    private readonly int $attack;
    private readonly int $defence;
    private readonly int $maxHealth;
    private int $currentHealth;

    public function __construct(int $lvl, Stats $baseStats)
    {
        if ($lvl < 1) {
            throw new \DomainException('Level can not be lesser than 1');
        }

        $bonusAttack  = 0;
        $bonusDefence = 0;
        $bonusHealth  = 0;

        if ($lvl !== 1) {
            $bonusAttack  = (int)ceil($lvl / 3);
            $bonusDefence = (int)ceil($lvl / 3);
            $bonusHealth  = (int)round($lvl * 1.5);
            if ($baseStats->currentHealth() === 0) {
                $bonusHealth = 0;
            }
        }

        $this->attack  = $baseStats->attack() + $bonusAttack;
        $this->defence = $baseStats->defence() + $bonusDefence;

        $this->maxHealth = $baseStats->maxHealth() + $bonusHealth;

        $currentHealth = $baseStats->currentHealth() + $bonusHealth;

        if ($baseStats->currentHealth() === $baseStats->maxHealth()) {
            $currentHealth = $baseStats->maxHealth();
        }

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

    public function loseHealth(int $amount): void
    {
        $this->currentHealth -= $amount;
        if ($this->currentHealth < 0) {
            $this->currentHealth = 0;
        }
    }

    public function restoreHealth(int $amount): void
    {
        $this->currentHealth += $amount;
        if ($this->currentHealth > $this->maxHealth) {
            $this->currentHealth = $this->maxHealth;
        }
    }
}
