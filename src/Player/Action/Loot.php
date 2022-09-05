<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Action;

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Player\Player;

class Loot
{
    public function __construct(private readonly Player $player)
    {

    }

    public function perform(Battle $on): void
    {
        if ($on->player() !== $this->player) {
            throw new \DomainException('Player was not participating in battle');
        }

        if (!$on->isOver()) {
            throw new \DomainException('Battle is not over yet.');
        }

        if (!$this->player->isAlive()) {
            throw new \DomainException('Player lost the battle. How do you expect receiving rewards?');
        }

        foreach ($on->issueRewards() as $drop) {
            $this->player->loot($drop);
        }
    }
}
