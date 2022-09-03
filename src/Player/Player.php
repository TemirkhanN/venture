<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Character\Stats;

class Player implements Battle\TargetInterface
{
    private string $name;

    private Stats $stats;

    public function __construct(string $name, Stats $stats)
    {
        $this->name = $name;
        $this->stats = $stats;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isAlive(): bool
    {
        return $this->stats->currentHealth !== 0;
    }

    public function stats(): Stats
    {
        return $this->stats;
    }
}
