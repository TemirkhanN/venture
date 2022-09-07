<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Npc;

use TemirkhanN\Venture\Battle\TargetInterface;
use TemirkhanN\Venture\Character\StatsInterface;

class Npc implements TargetInterface
{
    public readonly int $id;

    private string $name;

    private StatsInterface $stats;

    public function __construct(int $id, string $name, StatsInterface $stats)
    {
        $this->id = $id;
        $this->name  = $name;
        $this->stats = $stats;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function stats(): StatsInterface
    {
        return $this->stats;
    }

    public function isAlive(): bool
    {
        return $this->stats->currentHealth() > 0;
    }
}
