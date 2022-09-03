<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Npc;

use TemirkhanN\Venture\Battle\TargetInterface;
use TemirkhanN\Venture\Character\Stats;

class Npc implements TargetInterface
{
    private string $name;

    private Stats $stats;

    public function __construct(string $name, Stats $stats)
    {
        $this->name  = $name;
        $this->stats = $stats;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function stats(): Stats
    {
        return $this->stats;
    }

    public function isAlive(): bool
    {
        return $this->stats->currentHealth > 0;
    }
}
