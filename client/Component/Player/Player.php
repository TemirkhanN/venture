<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Component\Player;

class Player
{
    public function __construct(public readonly \TemirkhanN\Venture\Player\Player $player, public PlayerState $state = PlayerState::Idle) {}
}
