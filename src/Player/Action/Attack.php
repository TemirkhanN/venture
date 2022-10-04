<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Player\Action;

use TemirkhanN\Venture\Battle;

class Attack implements Battle\ActionInterface
{
    public function perform(Battle\Battle $at): void
    {
        if (!$at->isStarted() || $at->isOver()) {
            throw new \DomainException('Can not perform actions in inactive battle.');
        }

        if (!$at->doesCurrentTurnBelongToPlayer()) {
            throw new \DomainException('Current turn does not belong to player.');
        }

        $player = $at->player();
        $target = $at->enemy();

        if (!$player->isAlive() || !$target->isAlive()) {
            throw new \DomainException('The battle should be already over');
        }

        $damage = $player->stats()->attack() - $target->stats()->defence();
        if ($damage < 0) {
            $damage = 0;
        }
        $target->loseHp($damage);

        $at->addLog(sprintf('%s dealt %d damage to %s', $player->name(), $damage, $target->name()));

        if (!$target->isAlive()) {
            $at->addLog('Victory!');
        }
    }
}
