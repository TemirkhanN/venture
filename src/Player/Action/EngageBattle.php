<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Action;

use TemirkhanN\Venture\Battle;
use TemirkhanN\Venture\Player\Player;

class EngageBattle implements Battle\ActionInterface
{
    private Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function perform(Battle\Battle $at): void
    {
        if ($at->isStarted()) {
            throw new \DomainException('This battle has already started.');
        }

        $at->start($this->player);

        $at->addLog(sprintf('%s started battle with %s', $at->player()->name(), $at->enemy()->name()));
    }
}
