<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Event;

use TemirkhanN\Venture\Player\Player;

class PlayerCreated
{
    public function __construct(private readonly Player $player) {}

    public function player(): Player
    {
        return $this->player;
    }
}
