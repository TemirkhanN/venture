<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Action;

use TemirkhanN\Venture\Battle\Battle;
use TemirkhanN\Venture\Drop\Drop;
use TemirkhanN\Venture\Drop\GenerateDrop;
use TemirkhanN\Venture\Player\Player;

class GetBattleRewards
{
    public function __construct(private readonly Player $player, private readonly GenerateDrop $dropGenerator)
    {

    }

    public function receiveRewards(Battle $from): void
    {
        if ($from->player() !== $this->player) {
            throw new \DomainException('Player was not participating in battle');
        }

        if (!$from->isOver()) {
            throw new \DomainException('Battle is not over yet.');
        }

        if (!$this->player->isAlive()) {
            throw new \DomainException('Player lost the battle. How do you expect receiving rewards?');
        }

        foreach ($this->dropGenerator->execute($from->enemy()) as $drop) {
            $this->player->loot($drop);
            $from->addLog(
                sprintf('%s received %d %s', $this->player->name(), $drop->amount, $drop->item->name())
            );
        }
    }
}
