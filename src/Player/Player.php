<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player;

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Character;

class Player implements Battle\TargetInterface
{
    use Character\CharacterTrait;

    private Character\Stats $stats;

    public function __construct(string $name, Character\Stats $stats)
    {
        $this->name = $name;
        $this->stats = $stats;
        $this->equipment = new Character\Equipment\Equipment();
    }
}
