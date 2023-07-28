<?php

declare(strict_types=1);

namespace GameClient\Component\Player;

class Player
{
    public function __construct(public readonly \TemirkhanN\Venture\Player\Player $player, public PlayerState $state = PlayerState::Idle) {}
}
