<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Character;

interface StatsInterface
{
    public function attack(): int;
    public function defence(): int;
    public function maxHealth(): int;
    public function currentHealth(): int;
    public function decreaseHealth(int $amount): void;
    public function increaseHealth(int $amount): void;
}
