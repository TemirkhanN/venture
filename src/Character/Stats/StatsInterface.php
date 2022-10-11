<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character\Stats;

interface StatsInterface
{
    public function attack(): int;
    public function defence(): int;
    public function maxHealth(): int;
    public function currentHealth(): int;
    public function loseHealth(int $amount): void;
    public function restoreHealth(int $amount): void;
}
