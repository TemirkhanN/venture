<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Npc;

use TemirkhanN\Venture\Battle\TargetInterface;
use TemirkhanN\Venture\Character\CharacterTrait;
use TemirkhanN\Venture\Character\Equipment\Equipment;
use TemirkhanN\Venture\Character\StatsInterface;

class Npc implements TargetInterface
{
    use CharacterTrait;

    public readonly int $id;

    public function __construct(int $id, string $name, StatsInterface $stats)
    {
        $this->id = $id;
        $this->name  = $name;
        $this->stats = $stats;
        $this->equipment = new Equipment();
    }
}
