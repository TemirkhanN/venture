<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Npc;

use TemirkhanN\Venture\Character\CharacterInterface;
use TemirkhanN\Venture\Character\CharacterTrait;
use TemirkhanN\Venture\Character\Equipment\Equipment;
use TemirkhanN\Venture\Character\StatsInterface;

class Npc implements CharacterInterface
{
    use CharacterTrait;

    public readonly int $id;
    public readonly string $objectId;

    public function __construct(int $id, string $name, StatsInterface $stats)
    {
        $this->id = $id;
        $this->name  = $name;
        $this->stats = $stats;
        $this->equipment = new Equipment();
        $this->objectId = uniqid('npc', true);
    }
}
