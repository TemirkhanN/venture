<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Stats;

abstract class AbstractBoostedStats implements StatsInterface
{
    protected int $bonusAttack;
    protected int $bonusDefence;
    protected int $bonusHealth;

    public function __construct(private readonly StatsInterface $baseStats)
    {
    }

    public function attack(): int
    {
        return $this->bonusAttack + $this->baseStats->attack();
    }

    public function defence(): int
    {
        return $this->bonusDefence + $this->baseStats->defence();
    }

    public function maxHealth(): int
    {
        return $this->bonusHealth + $this->baseStats->maxHealth();
    }

    public function currentHealth(): int
    {
        return $this->bonusHealth + $this->baseStats->currentHealth();
    }

    public function loseHealth(int $amount): void
    {
        $this->baseStats->loseHealth($amount);
    }

    public function restoreHealth(int $amount): void
    {
        $this->baseStats->restoreHealth($amount);
    }
}
